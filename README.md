# Mivora Digital - Site Completo com Painel Administrativo

Um site profissional completo com banco de dados real, painel administrativo funcional e sistema de planos dinâmico.

## 🚀 Características Principais

### ✨ **Site Frontend**
- **Design Tecnológico**: Interface moderna com gradientes roxos e elementos futuristas
- **Totalmente Responsivo**: Funciona perfeitamente em desktop, tablet e mobile
- **Seção de Planos Dinâmica**: Carregada automaticamente do banco de dados
- **Galeria de Inspirações**: 5 sites reais como exemplos
- **Integração WhatsApp**: Links automáticos para cada plano
- **Animações Suaves**: Efeitos visuais profissionais

### 🗄️ **Banco de Dados Real**
- **SQLite**: Banco de dados leve e eficiente
- **Tabelas Estruturadas**: Planos, configurações e mensagens
- **Dados Pré-carregados**: 4 planos prontos para uso
- **API REST**: Endpoint para buscar dados dinamicamente

### 🔧 **Painel Administrativo**
- **Login Seguro**: Autenticação com senha criptografada
- **Gerenciar Planos**: Editar preços, descrições e recursos
- **Configurações Gerais**: WhatsApp, Instagram e título do site
- **Interface Moderna**: Design consistente com o site principal
- **Alterações em Tempo Real**: Mudanças refletem imediatamente no site

## 📁 Estrutura de Arquivos

```
mivora-digital-01/
├── index.html              # Página principal
├── styles.css              # Estilos CSS
├── script.js               # JavaScript interativo
├── README.md               # Esta documentação
├── assets/
│   ├── logo.png            # Logomarca da Mivora Digital
│   └── inspirations/       # Screenshots dos sites
│       ├── debetti.webp
│       ├── boldsnacks.webp
│       ├── soprata.webp
│       ├── samsonite.webp
│       └── sallve.webp
├── database/
│   ├── init.php            # Inicialização do banco
│   ├── Database.php        # Classe de conexão
│   └── mivora.db          # Banco SQLite (criado automaticamente)
├── admin/
│   ├── login.php          # Página de login
│   ├── index.php          # Painel principal
│   └── logout.php         # Logout
└── api/
    └── planos.php         # API REST para planos
```

## 🎨 Paleta de Cores

- **Fundo Principal**: `#09090B` (Preto)
- **Fundo Secundário**: `#0F0F0F` (Preto mais claro)
- **Texto Principal**: `#FFFFFF` (Branco)
- **Texto Secundário**: `#A1A1AA` (Cinza)
- **Accent Primary**: `#8C52FF` (Roxo)
- **Accent Secondary**: `#A855F7` (Roxo claro)

## 🔧 Configuração e Instalação

### Requisitos do Servidor
- **PHP 7.4+** com extensão SQLite3
- **Servidor Web** (Apache, Nginx ou similar)
- **Permissões de escrita** na pasta do banco de dados

### Instalação Rápida

1. **Extrair arquivos** no servidor web
2. **Executar inicialização** do banco:
   ```bash
   php database/init.php
   ```
3. **Configurar permissões**:
   ```bash
   chmod 755 database/
   chmod 666 database/mivora.db
   ```
4. **Acessar o site** no navegador

### Acesso ao Painel Admin
- **URL**: `seu-site.com/admin/login.php`
- **Senha padrão**: `admin123`
- **Recomendação**: Altere a senha após primeiro acesso

## 🌟 Funcionalidades Detalhadas

### Site Principal
- **Hero Section**: Apresentação impactante com call-to-actions
- **Seção de Planos**: 4 planos carregados dinamicamente do banco
- **Inspirações**: Galeria com 5 sites reais como exemplos
- **Modal de Preview**: Visualização das inspirações
- **Links WhatsApp**: Mensagens personalizadas para cada plano
- **Footer Completo**: Links e informações da empresa

### Painel Administrativo
- **Dashboard**: Estatísticas e visão geral
- **Gerenciar Planos**: 
  - Editar nome, preços e descrições
  - Modificar recursos inclusos
  - Ajustar preços de manutenção
  - Ativar/desativar planos
- **Configurações Gerais**:
  - URL do WhatsApp
  - URL do Instagram  
  - Título do site
- **Sistema de Login**: Autenticação segura

### Banco de Dados
- **Tabela planos**: Armazena todos os planos de serviço
- **Tabela configuracoes**: Settings gerais do site
- **Tabela mensagens_whatsapp**: Templates de mensagens
- **Relacionamentos**: Estrutura normalizada

### API REST
- **Endpoint**: `/api/planos.php`
- **Método**: GET
- **Resposta**: JSON com planos e configurações
- **CORS**: Habilitado para requisições cross-origin

## 📱 Responsividade

### Desktop (1200px+)
- Layout completo com sidebar
- Grid de 3-4 colunas para planos
- Navegação horizontal completa

### Tablet (768px - 1199px)
- Grid de 2 colunas
- Menu adaptado
- Espaçamentos otimizados

### Mobile (< 768px)
- Layout em coluna única
- Menu hamburger (simplificado)
- Botões e textos otimizados para toque

## 🔗 Integrações

### WhatsApp Business
- **URL Base**: `https://wa.link/yl761t`
- **Mensagens Personalizadas**: Para cada plano
- **Call-to-Actions**: Em múltiplos pontos do site

### Instagram
- **Perfil**: `@mivoradigital`
- **Links**: Header, footer e seção de contato

### Sites de Inspiração
1. **deBetti** - E-commerce premium de carnes
2. **Bold Snacks** - Barras de proteína vibrantes  
3. **Só Prata** - Joias elegantes
4. **Samsonite** - Corporativo moderno
5. **Sallve** - Dermocosméticos inovadores

## 🚀 Deploy e Hospedagem

### GitHub Pages (Limitado)
- **Limitação**: Não suporta PHP
- **Alternativa**: Usar versão estática sem banco de dados

### Hospedagem Compartilhada
1. Upload via FTP/cPanel
2. Executar `php database/init.php`
3. Configurar permissões
4. Testar funcionalidades

### VPS/Servidor Dedicado
1. Instalar PHP e extensões
2. Configurar servidor web
3. Upload dos arquivos
4. Configurar domínio

### Netlify/Vercel (Limitado)
- **Limitação**: Não suportam PHP
- **Solução**: Migrar para Node.js ou usar JAMstack

## 🔒 Segurança

### Medidas Implementadas
- **Senhas Criptografadas**: Hash bcrypt
- **Validação de Entrada**: Sanitização de dados
- **Sessões Seguras**: Controle de acesso ao admin
- **SQL Injection**: Prevenção com prepared statements
- **XSS Protection**: Escape de dados de saída

### Recomendações Adicionais
- Alterar senha padrão do admin
- Usar HTTPS em produção
- Backup regular do banco de dados
- Monitorar logs de acesso

## 📊 Performance

### Otimizações
- **Imagens WebP**: Formato otimizado
- **CSS Minificado**: Estilos organizados
- **JavaScript Otimizado**: Código limpo
- **Lazy Loading**: Carregamento sob demanda
- **Caching**: Headers apropriados

### Métricas Esperadas
- **Tempo de Carregamento**: < 3 segundos
- **Tamanho Total**: ~2MB
- **Lighthouse Score**: 90+
- **Mobile Friendly**: 100%

## 🛠️ Manutenção

### Tarefas Regulares
- Backup do banco de dados
- Atualização de conteúdo via painel
- Monitoramento de performance
- Verificação de links externos

### Logs e Monitoramento
- Logs de acesso ao admin
- Erros de banco de dados
- Performance do site
- Uptime monitoring

## 📞 Suporte

### Contatos
- **WhatsApp**: https://wa.link/yl761t
- **Instagram**: @mivoradigital
- **Email**: Configurar conforme necessário

### Documentação Técnica
- Código comentado
- Estrutura clara de arquivos
- README detalhado
- Exemplos de uso

---

**Desenvolvido por Mivora Digital** - Transformando ideias em experiências digitais completas! 🚀

**Versão**: 1.0  
**Data**: Setembro 2024  
**Tecnologias**: HTML5, CSS3, JavaScript ES6+, PHP 8.1, SQLite3
