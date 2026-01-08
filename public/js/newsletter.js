document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('newsletter-modal');
    const openBtn = document.getElementById('btn-newsletter');
    const closeBtn = document.getElementById('close-newsletter-modal');
    const form = document.getElementById('newsletter-form');
    const feedback = document.getElementById('newsletter-feedback');
    const emailInput = document.getElementById('newsletter-email');

    if (!modal || !openBtn || !form) return;

    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : null;

    /* =========================
       ABRIR / FECHAR MODAL
    ========================== */

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        emailInput?.focus();
    });

    modal.querySelector('.modal-backdrop')
        .addEventListener('click', closeModal);

    closeBtn.addEventListener('click', closeModal);

    function closeModal() {
        modal.classList.add('hidden');
        feedback.textContent = '';
        form.reset();
    }

    /* =========================
       SUBMIT DO FORMULÁRIO
    ========================== */

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = emailInput.value.trim();

        //ajeitando o botão...
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;


        if (!email) {
            feedback.textContent = '❌ Informe um e-mail válido';
            return;
        }

        feedback.textContent = 'Enviando...';

        try {
            const response = await fetch('/api/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(csrfToken && { 'X-CSRF-TOKEN': csrfToken })
                },
                body: JSON.stringify({ email })
            });

            let data = null;

            try {
                data = await response.json();
            } catch {
                throw new Error('Resposta inválida do servidor');
            }

            if (!response.ok) {
                throw new Error(data.message || 'Erro ao inscrever');
            }

            feedback.textContent = '✅ Inscrição realizada com sucesso';

            setTimeout(closeModal, 1500);

        } catch (err) {
            feedback.textContent = '❌ ' + err.message;
        }

        //resetando o botão
        submitButton.disabled = false;
        
    });
});
