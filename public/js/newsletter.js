document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('newsletter-modal');
    const openBtn = document.getElementById('btn-newsletter');
    const closeBtn = document.getElementById('close-newsletter-modal');
    const form = document.getElementById('newsletter-form');
    const feedback = document.getElementById('newsletter-feedback');

    if (!modal || !openBtn) return;

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    modal.querySelector('.modal-backdrop')
        .addEventListener('click', closeModal);

    closeBtn.addEventListener('click', closeModal);

    function closeModal() {
        modal.classList.add('hidden');
        feedback.innerHTML = '';
        form.reset();
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('newsletter-email').value;
        feedback.innerHTML = 'Enviando...';

        try {
            const response = await fetch('/api/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                },
                body: JSON.stringify({ email })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Erro ao inscrever');
            }

            feedback.innerHTML = '✅ Inscrição realizada com sucesso';

            setTimeout(closeModal, 1500);

        } catch (err) {
            feedback.innerHTML = '❌ ' + err.message;
        }
    });
});
