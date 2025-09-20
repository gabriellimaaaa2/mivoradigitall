// Dados dos sites de inspiração
const inspirationData = {
    debetti: {
        title: 'deBetti - E-commerce Premium',
        url: 'https://debetti.com.br/',
        image: 'assets/inspirations/debetti.webp',
        description: 'E-commerce premium de carnes dry aged com design elegante e funcional, focado na experiência do usuário e apresentação sofisticada dos produtos.'
    },
    boldsnacks: {
        title: 'Bold Snacks - Energia e Vitalidade',
        url: 'https://www.boldsnacks.com.br/',
        image: 'assets/inspirations/boldsnacks.webp',
        description: 'Site vibrante de barras de proteína com design jovem e energético, utilizando cores vibrantes e elementos dinâmicos para transmitir força e vitalidade.'
    },
    soprata: {
        title: 'Só Prata - Elegância em Joias',
        url: 'https://www.soprata.com.br/',
        image: 'assets/inspirations/soprata.webp',
        description: 'E-commerce sofisticado de joias com navegação intuitiva e design clean, priorizando a apresentação elegante dos produtos e facilidade de compra.'
    },
    samsonite: {
        title: 'Samsonite - Tradição e Modernidade',
        url: 'https://samsonite.com.br/',
        image: 'assets/inspirations/samsonite.webp',
        description: 'Site corporativo moderno com foco em produtos e experiência do usuário, combinando tradição da marca com design contemporâneo e funcional.'
    },
    sallve: {
        title: 'Sallve - Inovação em Dermocosméticos',
        url: 'https://www.sallve.com.br/',
        image: 'assets/inspirations/sallve.webp',
        description: 'Design inovador para dermocosméticos com interface interativa e moderna, utilizando elementos visuais únicos e experiência de usuário diferenciada.'
    }
};

// Dados dos planos (fallback caso não consiga carregar do banco )
const planosDefault = [
    {
        id: 1,
        nome: 'Site Básico com Domínio Gratuito',
        preco_original: 1200.00,
        preco_promocional: 899.00,
        descricao: 'Site profissional moderno com painel administrativo simples e domínio gratuito incluso.',
        recursos: [
            'Site profissional moderno',
            'Painel administrativo simples',
            'Domínio gratuito incluso',
            'Manual completo de uso',
            'Alterações em tempo real'
        ],
        manutencao_preco: 150.00,
        whatsapp_link: 'https://wa.me/5588998581489',
        whatsapp_message: 'Olá! Tenho interesse no plano *Site Básico com Domínio Gratuito* por R$ 899,00. Gostaria de mais informações!'
    },
    {
        id: 2,
        nome: 'Site + Hospedagem Profissional',
        preco_original: 1500.00,
        preco_promocional: 1100.00,
        descricao: 'Tudo do Plano 1 com painel administrativo avançado e hospedagem profissional.',
        recursos: [
            'Tudo do Plano 1',
            'Painel administrativo avançado',
            'Hospedagem profissional',
            'Maior espaço e backup automático',
            'SSL incluso',
            'Alterar cores e promoções'
        ],
        manutencao_preco: 200.00,
        whatsapp_link: 'https://wa.me/5588998581489',
        whatsapp_message: 'Olá! Tenho interesse no plano *Site + Hospedagem Profissional* por R$ 1.100,00. Gostaria de mais informações!'
    },
    {
        id: 3,
        nome: 'Site + Hospedagem + Instagram + E-book',
        preco_original: 2000.00,
        preco_promocional: 1500.00,
        descricao: 'Tudo do Plano 2 com organização do Instagram e E-books exclusivos de vendas.',
        recursos: [
            'Tudo do Plano 2',
            'Organização do Instagram',
            'E-books exclusivos de vendas',
            'Estratégias de marketing',
            'Consultoria digital'
        ],
        manutencao_preco: 250.00,
        whatsapp_link: 'https://wa.me/5588998581489',
        whatsapp_message: 'Olá! Tenho interesse no plano *Site + Hospedagem + Instagram + E-book* por R$ 1.500,00. Gostaria de mais informações!'
    },
    {
        id: 4,
        nome: 'Personalizado',
        preco_original: 0.00,
        preco_promocional: 0.00,
        descricao: 'Criação de site exclusivo e personalizado conforme necessidade do cliente.',
        recursos: [
            'Site exclusivo e personalizado',
            'Desenvolvimento sob medida',
            'Funcionalidades específicas',
            'Design único',
            'Consultoria completa'
        ],
        manutencao_preco: 0.00,
        whatsapp_link: 'https://wa.me/5588998581489',
        whatsapp_message: 'Olá! Tenho interesse no plano *Personalizado*. Gostaria de discutir minha necessidade específica!'
    }
];

// Variável global para armazenar dados dos planos
let planosData = null;

// Função para carregar planos do banco de dados
async function carregarPlanos( ) {
    try {
        // Tentar carregar do banco de dados primeiro
        const response = await fetch('api/planos.php');
        
        if (response.ok) {
            const data = await response.json();
            
            if (data.success) {
                planosData = data;
                renderizarPlanos(data.planos);
                configurarLinksWhatsApp(data.whatsapp_url);
                console.log('✅ Planos carregados do banco de dados');
                return;
            }
        }
        
        throw new Error('API não disponível');
        
    } catch (error) {
        console.log('⚠️ Banco de dados não disponível, usando dados padrão');
        // Usar dados padrão se não conseguir carregar do banco
        usarDadosPadrao();
    }
}

// Função para usar dados padrão
function usarDadosPadrao() {
    planosData = {
        success: true,
        planos: planosDefault,
        whatsapp_url: 'https://wa.me/5588998581489'
    };
    
    renderizarPlanos(planosDefault );
    configurarLinksWhatsApp('https://wa.me/5588998581489' );
    console.log('✅ Planos carregados com dados padrão');
}

// Função para renderizar planos na página
function renderizarPlanos(planos) {
    const grid = document.getElementById('planos-grid');
    
    if (!planos || planos.length === 0) {
        grid.innerHTML = '<div class="loading-planos"><p>Nenhum plano disponível no momento.</p></div>';
        return;
    }
    
    const planosHTML = planos.map((plano, index) => {
        const recursos = plano.recursos.map(recurso => `<li>${recurso}</li>`).join('');
        const isDestaque = index === 1; // Segundo plano como destaque
        const isPersonalizado = plano.nome.toLowerCase().includes('personalizado');
        
        return `
            <div class="plano-card ${isDestaque ? 'destaque' : ''}">
                <div class="plano-header">
                    <h3 class="plano-nome">${plano.nome}</h3>
                    ${!isPersonalizado ? `
                        <div class="plano-preco">
                            ${plano.preco_original > 0 ? `<span class="preco-original">R$ ${formatarPreco(plano.preco_original)}</span>` : ''}
                            <span class="preco-promocional">R$ ${formatarPreco(plano.preco_promocional)}</span>
                        </div>
                    ` : '<div class="plano-preco"><span class="preco-promocional">Sob Consulta</span></div>'}
                </div>
                
                <p class="plano-descricao">${plano.descricao}</p>
                
                <ul class="plano-recursos">
                    ${recursos}
                </ul>
                
                ${plano.manutencao_preco > 0 ? `
                    <div class="plano-manutencao">
                        <strong>Manutenção Opcional:</strong> R$ ${formatarPreco(plano.manutencao_preco)}/mês
                    </div>
                ` : ''}
                
                <a href="${plano.whatsapp_link}?text=${encodeURIComponent(plano.whatsapp_message)}" 
                   target="_blank" 
                   class="plano-button ${isPersonalizado ? 'personalizado' : ''}">
                    ${isPersonalizado ? 'Solicitar Orçamento' : 'Escolher Plano'}
                </a>
            </div>
        `;
    }).join('');
    
    grid.innerHTML = planosHTML;
}

// Função para mostrar erro no carregamento dos planos
function mostrarErroPlanos() {
    const grid = document.getElementById('planos-grid');
    grid.innerHTML = `
        <div class="loading-planos">
            <p style="color: #DC2626;">Erro ao carregar planos. Usando dados padrão.</p>
            <button onclick="carregarPlanos()" class="primary-button" style="margin-top: 20px;">
                Tentar Novamente
            </button>
        </div>
    `;
    
    // Usar dados padrão após 2 segundos
    setTimeout(() => {
        usarDadosPadrao();
    }, 2000);
}

// Função para formatar preço
function formatarPreco(preco) {
    return new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(preco);
}

// Função para configurar links do WhatsApp
function configurarLinksWhatsApp(whatsappUrl) {
    const links = ['whatsapp-header', 'whatsapp-cta', 'whatsapp-footer'];
    const mensagemGeral = 'Olá! Visitei o site da Mivora Digital e gostaria de mais informações sobre os serviços!';
    
    links.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.href = `${whatsappUrl}?text=${encodeURIComponent(mensagemGeral)}`;
        }
    });
}

// Função para abrir preview do site
function openPreview(siteKey) {
    const site = inspirationData[siteKey];
    if (!site) return;
    
    const modal = document.getElementById('previewModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalImage = document.getElementById('modalImage');
    const modalLink = document.getElementById('modalLink');
    
    modalTitle.textContent = site.title;
    modalImage.src = site.image;
    modalImage.alt = site.title;
    modalLink.href = site.url;
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Adicionar animação de entrada
    modal.style.opacity = '0';
    setTimeout(() => {
        modal.style.opacity = '1';
        modal.style.transition = 'opacity 0.3s ease';
    }, 10);
}

// Função para fechar preview
function closePreview() {
    const modal = document.getElementById('previewModal');
    modal.style.opacity = '0';
    
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }, 300);
}

// Fechar modal ao clicar fora dele
window.onclick = function(event) {
    const modal = document.getElementById('previewModal');
    if (event.target === modal) {
        closePreview();
    }
}

// Fechar modal com tecla ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePreview();
    }
});

// Animações de scroll
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observar elementos para animação
    const animateElements = document.querySelectorAll('.plano-card, .inspiration-card, .section-header, .cta-content');
    animateElements.forEach(el => {
        observer.observe(el);
    });
}

// Smooth scroll para links internos
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Header scroll effect
function initHeaderEffect() {
    const header = document.querySelector('.header');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 100) {
            header.style.background = 'rgba(9, 9, 11, 0.95)';
            header.style.backdropFilter = 'blur(20px)';
        } else {
            header.style.background = 'rgba(9, 9, 11, 0.8)';
            header.style.backdropFilter = 'blur(20px)';
        }
        
        // Hide/show header on scroll
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
}

// Lazy loading para imagens
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.remove('loading');
                    observer.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            img.classList.add('loading');
            imageObserver.observe(img);
        });
    }
}

// Adicionar efeitos de hover aos cards
function initCardEffects() {
    // Efeitos serão aplicados via CSS
    console.log('Card effects initialized via CSS');
}

// Adicionar ripple effect aos botões
function initRippleEffect() {
    const buttons = document.querySelectorAll('.primary-button, .secondary-button, .preview-btn, .visit-btn, .plano-button');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

// Contador de visitantes (simulado)
function initVisitorCounter() {
    const counter = document.createElement('div');
    counter.className = 'visitor-counter';
    counter.innerHTML = `
        <div style="
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            border: 1px solid var(--border-color);
            z-index: 1000;
            backdrop-filter: blur(10px);
        ">
            👥 ${Math.floor(Math.random() * 50) + 100} pessoas online
        </div>
    `;
    
    document.body.appendChild(counter);
    
    // Atualizar contador periodicamente
    setInterval(() => {
        const count = Math.floor(Math.random() * 50) + 100;
        counter.querySelector('div').innerHTML = `👥 ${count} pessoas online`;
    }, 30000);
}

// Adicionar CSS para animações
function addAnimationStyles() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .plano-card,
        .inspiration-card,
        .section-header,
        .cta-content {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        
        .plano-card.animate-in,
        .inspiration-card.animate-in,
        .section-header.animate-in,
        .cta-content.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        .loading {
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }
    `;
    
    document.head.appendChild(style);
}

// Função para detectar se está rodando em servidor
function isRunningOnServer() {
    return window.location.protocol === 'http:' || window.location.protocol === 'https:';
}

// Inicializar todas as funcionalidades quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', async function( ) {
    // Adicionar estilos de animação
    addAnimationStyles();
    
    // Carregar planos (com fallback)
    await carregarPlanos();
    
    // Inicializar funcionalidades
    initScrollAnimations();
    initSmoothScroll();
    initHeaderEffect();
    initLazyLoading();
    initCardEffects();
    initRippleEffect();
    initVisitorCounter();
    
    // Adicionar loading state inicial
    document.body.classList.add('loaded');
    
    console.log('🚀 Mivora Digital - Site carregado com sucesso!');
    console.log('📊 Planos carregados:', planosData?.planos?.length || 0);
    console.log('🌐 Servidor:', isRunningOnServer() ? 'Sim' : 'Não (arquivo local)');
});

// Adicionar loading state
window.addEventListener('load', function() {
    document.body.classList.add('fully-loaded');
});

// Performance monitoring
if ('performance' in window) {
    window.addEventListener('load', function() {
        setTimeout(() => {
            const perfData = performance.timing;
            const loadTime = perfData.loadEventEnd - perfData.navigationStart;
            console.log(`⚡ Tempo de carregamento: ${loadTime}ms`);
        }, 0);
    });
}

// Função para recarregar planos (útil para o painel admin)
window.recarregarPlanos = carregarPlanos;

// Exportar funções globais necessárias
window.openPreview = openPreview;
window.closePreview = closePreview;
