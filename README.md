# 📬 Laravel Newsletter Toy Project

Este repositório é um **toy project em Laravel** criado com o objetivo de **estudar, testar e comparar diferentes abordagens de envio de e‑mail** em aplicações web reais.

O projeto simula um **sistema simples de notícias/blog**, onde a publicação de um novo post pode disparar e‑mails para uma newsletter, utilizando **duas metodologias distintas**:

- 📦 **Envio local (Mailpit)** – para desenvolvimento
- ☁️ **Envio real via API (Brevo / Sendinblue)** – para ambiente próximo de produção

> ⚠️ Este projeto **não é um produto final**, e sim um laboratório prático de arquitetura, integrações e boas práticas.

---

## 🎯 Objetivos do projeto

- Explorar diferentes **estratégias de envio de e‑mail** no Laravel
- Comparar **envio local vs envio via API externa**
- Aplicar boas práticas de arquitetura (Events, Listeners, Services)
- Manter controllers desacoplados de regras de envio
- Simular um fluxo real de **newsletter baseada em conteúdo**

---

## 🧱 Arquitetura geral

Quando uma nova notícia é publicada:

```
PostController
   ↓
Event: PostPublished
   ↓
Listener: SendPostToNewsletter
   ↓
Service: BrevoService (ou Mail local)
```

O controller **não envia e‑mails diretamente**. Toda a lógica de notificação fica isolada em **Events + Listeners**, permitindo trocar o provedor de e‑mail sem alterar o domínio da aplicação.

---

## ✉️ Metodologias de envio de e‑mail

### 1️⃣ Envio local com Mailpit (desenvolvimento)

Utilizado para desenvolvimento local, sem envio real de e‑mails.

**Características:**
- Nenhum e‑mail sai para a internet
- Ideal para testes rápidos
- Visualização via interface web

**Configuração típica:**
```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

A interface do Mailpit fica disponível em:
```
http://localhost:8025
```

---

### 2️⃣ Envio real via API (Brevo)

Integração com o **Brevo (antigo Sendinblue)** usando API HTTP para envio de e‑mails transacionais.

**Características:**
- Envio real de e‑mails
- Domínio autenticado (SPF / DKIM)
- Melhor controle de entregabilidade
- Integração desacoplada do Laravel Mail

O envio ocorre através de um service dedicado:

```
app/Services/BrevoService.php
```

Utilizando chamadas HTTP para a API oficial do Brevo.

---

## 🔔 Fluxo de newsletter

- Um post é criado no painel administrativo
- O evento `PostPublished` é disparado
- Um listener decide se deve notificar a newsletter
- O e‑mail é enviado:
  - localmente (Mailpit), ou
  - via API do Brevo

Atualmente, o envio é feito para um **e‑mail de teste**, configurado por ambiente.

---

## 🧪 Status atual

✔️ CRUD básico de posts
✔️ Publicação de notícias
✔️ Event + Listener funcionando
✔️ Integração com Brevo via API
✔️ Envio confirmado no dashboard do Brevo

Próximas evoluções possíveis:
- Envio em massa para inscritos reais
- Uso de filas (Queues)
- Templates transacionais
- Double opt‑in
- Agendamento de newsletters

---

## 🚧 O que este projeto **não é**

- ❌ Não é um sistema de newsletter completo
- ❌ Não é focado em UI
- ❌ Não é pronto para produção sem ajustes

Ele existe **apenas para estudo, testes e aprendizado prático**.

---

## 🛠️ Tecnologias utilizadas

- Laravel
- PHP
- Brevo API (Sendinblue)
- Mailpit
- MySQL / SQLite (dependendo do ambiente)

---

## 🧠 Motivação

Este projeto foi criado para entender **na prática**:

- Quando usar o Mail do Laravel
- Quando usar APIs externas
- Como desacoplar envio de e‑mail da lógica de negócio
- Como preparar um projeto para crescer sem refatorações dolorosas

---

## 📄 Licença

Projeto de estudo. Use, adapte e modifique livremente.

