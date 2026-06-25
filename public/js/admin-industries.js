const industryList = document.querySelector('[data-industry-list]');

const refreshIndustryOrder = () => {
    [...industryList.querySelectorAll('[data-industry-card]')].forEach((card, index) => {
        const orderInput = card.querySelector('.cms-order input');
        if (orderInput) orderInput.value = (index + 1) * 10;
    });
};

industryList?.addEventListener('click', (event) => {
    const card = event.target.closest('[data-industry-card]');

    if (!card) {
        return;
    }

    if (event.target.closest('[data-industry-toggle]')) {
        const button = card.querySelector('[data-industry-toggle]');
        const body = card.querySelector('[data-industry-body]');
        const isOpening = body.hidden;

        body.hidden = !isOpening;
        button.textContent = isOpening ? 'Collapse' : 'Expand';
        button.setAttribute('aria-expanded', String(isOpening));
    }

    if (event.target.closest('[data-industry-move-up]') && card.previousElementSibling) {
        industryList.insertBefore(card, card.previousElementSibling);
        refreshIndustryOrder();
    }

    if (event.target.closest('[data-industry-move-down]') && card.nextElementSibling) {
        industryList.insertBefore(card.nextElementSibling, card);
        refreshIndustryOrder();
    }
});
