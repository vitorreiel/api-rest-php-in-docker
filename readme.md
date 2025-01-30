# 🚀 CI/CD Pipeline with Jenkins, Terraform & Docker  

Este repositório contém toda a configuração necessária para a **pipeline CI/CD automatizada** utilizando **Jenkins, Terraform e Docker**. O projeto abrange desde o **provisionamento da infraestrutura na Google Cloud (GCP)** até a **containerização, deploy e testes automatizados**.

<br>

## 📌 Tecnologias Utilizadas  

- **Google Cloud Platform (GCP)** → Infraestrutura nuvem escalável e segura.  
- **Terraform** → Provisionamento automatizado da infraestrutura.  
- **Docker** → Containerização das aplicações (frontend, backend e banco de dados).  
- **Jenkins** → Automação da pipeline CI/CD.  
- **Cypress** → Testes automatizados E2E da interface.  
- **PHP (Backend)** → API RESTful conectada ao MySQL.  
- **JavaScript (Frontend)** → Interface simples para consumir a API.  
- **MySQL** → Banco de dados relacional para persistência de dados.  

<br>

## 📂 Estrutura do Repositório  

📁 **infra/** → Scripts Terraform para provisionamento no GCP (Compute Engine, Networking, etc.).  
📁 **docker/** → Dockerfiles para construir as imagens dos containers.  
📁 **jenkins/** → Configuração da pipeline CI/CD.  
📁 **frontend/** → Aplicação frontend simples em JavaScript.  
📁 **backend/** → API backend em PHP com integração ao MySQL.  
📁 **tests/** → Testes unitários e automatizados E2E (Cypress).  

<br>

## 🚀 Automação com CI/CD no Jenkins  

De forma resumida, a pipeline no **Jenkins** realiza os seguintes passos de forma automatizada:  

1️⃣ **Clone do repositório** quando houver **commits na branch `main`** via **Webhooks**.  
2️⃣ **Execução de testes unitários e E2E com Cypress**.  
3️⃣ **Construção das imagens Docker e push para o registry**.  
4️⃣ **Instalação de todas as dependências**.  
5️⃣ **Deploy automatizado das aplicações** nos containers.  

<br>

### 📌 Configurando o Webhook no GitHub  

Para disparar a pipeline automaticamente em cada commit, configure um **Webhook no GitHub** apontando para:  

```sh
http://<JENKINS-IP>:8080/github-webhook/
```
<br>

## 🛠️ Como Executar o Projeto  

### **1️⃣ Provisionar a Infraestrutura no GCP**
```sh
cd terraform/
terraform init
terraform apply -auto-approve
```

### 2️⃣ **Configuração do Jenkins, contruir uma pipeline, inserir as variáveis de ambiente apontar para o repositório atual**. 

### 3️⃣ **Após contrução da Pipeline, executar e aguardar**.
O docker fará a execução dos container com:
```sh
docker compose up -d
```


### 4️⃣ **Testar a aplicação**

Abra no navegador:

```sh
http://<EXTERNAL-IP-FRONTEND>
```
<br>

## 🔥 Testes Automatizados
Este repositório inclui testes unitários e testes de interface E2E com Cypress.

Executar os testes localmente:
```sh
cd cypress/
npm install
npx cypress open
```

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
    <img height="34" width="30" hspace="7" src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/cypressio/cypressio-original.svg" />
</div>