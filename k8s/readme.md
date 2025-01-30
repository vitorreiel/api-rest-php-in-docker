# 🚀 Kubernetes Configurations on Google Cloud (GCP)

Aqui você encontrará todos os arquivos de configuração do **Kubernetes** utilizados para a implantação dos cenários no **Google Kubernetes Engine (GKE)** da **Google Cloud (GCP)**.  

<br>

## 📂 Estrutura do Repositório

O repositório contém arquivos YAML para a configuração de **Deployments, Services, Namespaces e ConfigMaps**, garantindo a infraestrutura necessária para execução dos serviços no GKE. Vale ressaltar que este é um ambiente separado do restante do repositório.

<br>

### 📌 Tecnologias Utilizadas
- **Google Kubernetes Engine (GKE)** → Orquestração de containers na Google Cloud.
- **Kubernetes (Minikube)** → Gerenciamento e automação dos containers.
- **Docker** → Containerização das aplicações.
- **Prometheus + Node Exporter** → Monitoramento do ambiente.
- **Nginx** → Servidor web para o frontend.
- **MySQL** → Banco de dados para persistência de dados.

<br>

## 📄 Configurações Disponíveis

- **Backend** → Aplicação rodando como **Deployment + Service**.
- **Frontend** → Servido via **Nginx + Service LoadBalancer**.
- **Banco de Dados (MySQL)** → Persistência de dados utilizando **ClusterIP**.
- **Monitoramento** → Stack **Grafana + Prometheus + Node Exporter** para métricas e análise.

<br>

---

<div style="display: inline_block;">
   <img height="34" width="34" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg" />
   <img height="34" width="30" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/terraform/terraform-original.svg" />
   <img height="34" width="30" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/kubernetes/kubernetes-original.svg" />
   <img height="34" width="30" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/googlecloud/googlecloud-original.svg" />
   <img height="34" width="30" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/grafana/grafana-original.svg" />
   <img height="34" width="30" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/prometheus/prometheus-original.svg" />
    <img height="34" width="34" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg" />
    <img height="34" width="30" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg" />
</div>