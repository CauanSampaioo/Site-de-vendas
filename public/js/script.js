// Smooth scroll para links de navegação
document.querySelectorAll('nav a').forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href.startsWith('#')) {
            e.preventDefault();
            const targetElement = document.querySelector(href);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Efeito de animação ao carregar a página
window.addEventListener('load', function() {
    const articles = document.querySelectorAll('article');
    articles.forEach((article, index) => {
        article.style.opacity = '0';
        article.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            article.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            article.style.opacity = '1';
            article.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Efeito de ativa na navegação durante o scroll
window.addEventListener('scroll', function() {
    let current = '';
    const sections = document.querySelectorAll('section');
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.pageYOffset >= sectionTop - 200) {
            current = section.getAttribute('id');
        }
    });
    
    document.querySelectorAll('nav a').forEach(link => {
        const href = link.getAttribute('href');
        if (href.startsWith('#')) {
            link.style.color = '#a0a0a0';
            if (href === '#' + current) {
                link.style.color = '#ff006e';
            }
        }
    });
});

// Contador de visitas
function initVisitCounter() {
    let visits = localStorage.getItem('visitCount') || 0;
    visits = parseInt(visits) + 1;
    localStorage.setItem('visitCount', visits);
    console.log(`Você visitou esta página ${visits} vezes!`);
}

// Inicializar contador
initVisitCounter();

// Função para pesquisar produtos
function searchProducts(keyword) {
    const articles = document.querySelectorAll('article');
    let found = 0;
    
    articles.forEach(article => {
        const text = article.innerText.toLowerCase();
        if (text.includes(keyword.toLowerCase())) {
            article.style.display = 'block';
            found++;
        } else {
            article.style.display = 'none';
        }
    });
    
    return found;
}

// Função para adicionar ao carrinho
function addToCart(productName) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push({
        name: productName,
        date: new Date().toLocaleString('pt-BR')
    });
    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${productName} adicionado ao carrinho!`);
}

// Efeito de hover nos cards de produto
document.querySelectorAll('article').forEach(article => {
    article.addEventListener('mouseenter', function() {
        this.style.borderLeftColor = '#ff006e';
    });
    
    article.addEventListener('mouseleave', function() {
        this.style.borderLeftColor = '#00d4ff';
    });
});

// Função para obter horário de funcionamento
function getStoreStatus() {
    const hour = new Date().getHours();
    const isOpen = hour >= 9 && hour < 20;
    return isOpen ? 'Loja aberta' : 'Loja fechada';
}

// Exibir status da loja no console
console.log('%cGameTech - ' + getStoreStatus(), 'color: #00d4ff; font-size: 16px; font-weight: bold;');

// Função para mostrar total de categorias
function getTotalCategories() {
    const categories = document.querySelectorAll('#produtos article').length;
    console.log(`%cTotal de categorias de produtos: ${categories}`, 'color: #ff006e; font-size: 14px;');
    return categories;
}

getTotalCategories();

// Tecla de atalho para voltar ao topo
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'Home') {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
