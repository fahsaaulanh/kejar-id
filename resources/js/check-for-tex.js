(function () {
    var body = document.body.textContent;
    if (body.match(/(?:\$|\\\(|\\\[|\\begin\{.*?})/)) {
        if (!window.MathJax) {
            window.MathJax = {
                options: {
                    renderActions: {
                        addMenu: [0, '', '']
                    }
                },
                tex: { inlineMath: [['$', '$'], ['\\(', '\\)']] },
                svg: { fontCache: 'global' }
            };
        }
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js';
        document.head.appendChild(script);
    }
})();
