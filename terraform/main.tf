provider "google" {
  project     = "case-project-449202"
  region      = "us-central1"       # Região
  zone        = "us-central1-a"    # Zona
  credentials = file("../../../case-project.json")
}

resource "google_compute_instance" "vm_with_docker" {
  name         = "instance"
  machine_type = "e2-standard-4"
  zone         = var.zone
  allow_stopping_for_update = true

  boot_disk {
    initialize_params {
      image = "ubuntu-os-cloud/ubuntu-2204-lts"
      size = 30 # Define 30GB de armazenamento interno
    }
  }

  network_interface {
    network       = "default"
    access_config {}
  }

  metadata_startup_script = <<-EOT
    #!/bin/bash
    # Update the repositories
    sudo apt-get update

    # Docker Installation
    curl -fsSL https://get.docker.com | bash
    sudo systemctl start docker
    sudo systemctl enable docker
    
    # Jenkins Installation
    sudo apt-get update
    sudo apt-get install -y openjdk-17-jdk # Instalação do Java 17
    sudo wget -O /usr/share/keyrings/jenkins-keyring.asc \
    https://pkg.jenkins.io/debian-stable/jenkins.io-2023.key
    echo "deb [signed-by=/usr/share/keyrings/jenkins-keyring.asc]" \
    https://pkg.jenkins.io/debian-stable binary/ | sudo tee \
    /etc/apt/sources.list.d/jenkins.list > /dev/null
    sudo apt-get update
    sudo apt-get install -y jenkins
    sudo systemctl start jenkins
    sudo systemctl enable jenkins
    sudo usermod -aG docker jenkins
    sudo systemctl restart jenkins

    # Installing PHP 8.1 and Composer
    sudo apt-get install -y software-properties-common
    sudo add-apt-repository -y ppa:ondrej/php
    sudo apt-get update
    sudo apt-get install -y php8.1 php8.1-cli php8.1-mbstring php8.1-xml unzip curl
    sudo apt install -y composer

    # Installing Node.js (v20) and NPM
    curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
    sudo apt-get update
    sudo apt-get install -y nodejs

    # Installing cypress dependencies
    sudo apt-get install -y libgtk-3-0 libgbm-dev libnotify-dev \
    libgconf-2-4 libnss3 libxss1 libasound2 libxtst6 xauth xvfb

    # Removing unused web server
    sudo apt-get remove -y apache2

  EOT

  tags = [
    "http-server",
    "https-server",
    "port-22",
    "port-8000",
    "port-8080",
    "port-9090",
    "port-9100",
    "port-3000"
  ]

  service_account {
    email  = "default"
    scopes = [
      "https://www.googleapis.com/auth/cloud-platform",
    ]
  }
}

resource "google_compute_firewall" "allow_ports" {
  name    = "allow-ports"
  network = "default"

  allow {
    protocol = "tcp"
    ports    = ["22", "80", "8000", "8080", "9090", "9100", "3000"]
  }

  source_ranges = ["0.0.0.0/0"]

  target_tags = [
    "http-server",
    "https-server",
    "port-22",
    "port-8000",
    "port-8080",
    "port-9090",
    "port-9100",
    "port-3000"
  ]
}

variable "zone" {
  description = "Zone for the VM."
  default     = "us-central1-a"
}