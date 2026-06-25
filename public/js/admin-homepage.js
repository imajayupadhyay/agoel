const createItemKey = () => `item-${Date.now()}-${Math.random().toString(36).slice(2, 9)}`;

const refreshRepeater = (repeater) => {
    const items = [...repeater.querySelectorAll(':scope > [data-repeater-list] > [data-repeater-item]')];

    items.forEach((item, index) => {
        item.querySelector('[data-item-label]').textContent = `Item ${index + 1}`;
        item.querySelectorAll('[name]').forEach((input) => {
            input.name = input.name.replace(/\[content\]\[([^\]]+)\]\[[^\]]+\]/, `[content][$1][${index}]`);
        });
    });
};

document.querySelectorAll('[data-repeater]').forEach((repeater) => {
    const list = repeater.querySelector('[data-repeater-list]');
    const template = repeater.querySelector('[data-repeater-template]');

    repeater.querySelector('[data-add-item]')?.addEventListener('click', () => {
        const index = list.querySelectorAll('[data-repeater-item]').length;
        const markup = template.innerHTML
            .replaceAll('__INDEX__', String(index))
            .replaceAll('__KEY__', createItemKey());

        list.insertAdjacentHTML('beforeend', markup);
        refreshRepeater(repeater);
    });

    list.addEventListener('click', (event) => {
        const item = event.target.closest('[data-repeater-item]');

        if (!item) {
            return;
        }

        if (event.target.closest('[data-remove-item]')) {
            item.remove();
            refreshRepeater(repeater);
        }

        if (event.target.closest('[data-move-up]') && item.previousElementSibling) {
            item.parentElement.insertBefore(item, item.previousElementSibling);
            refreshRepeater(repeater);
        }

        if (event.target.closest('[data-move-down]') && item.nextElementSibling) {
            item.parentElement.insertBefore(item.nextElementSibling, item);
            refreshRepeater(repeater);
        }
    });

    refreshRepeater(repeater);
});

document.querySelectorAll('[data-section-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const card = button.closest('[data-section-card]');
        const collapsed = card.classList.toggle('is-collapsed');
        button.textContent = collapsed ? 'Expand' : 'Collapse';
        button.setAttribute('aria-expanded', String(!collapsed));
    });
});

const refreshSectionOrder = () => {
    const cards = [...document.querySelectorAll('[data-cms-form] > [data-section-card]')];

    cards.forEach((card, index) => {
        const orderInput = card.querySelector('.cms-order input');
        if (orderInput) orderInput.value = (index + 1) * 10;
    });
};

document.querySelectorAll('[data-section-card]').forEach((card) => {
    card.querySelector('[data-section-move-up]')?.addEventListener('click', () => {
        const previous = card.previousElementSibling;
        if (previous?.matches('[data-section-card]')) {
            card.parentElement.insertBefore(card, previous);
            refreshSectionOrder();
        }
    });

    card.querySelector('[data-section-move-down]')?.addEventListener('click', () => {
        const next = card.nextElementSibling;
        if (next?.matches('[data-section-card]')) {
            card.parentElement.insertBefore(next, card);
            refreshSectionOrder();
        }
    });
});

document.querySelectorAll('[data-image-input]').forEach((input) => {
    input.addEventListener('change', () => {
        const file = input.files?.[0];
        const control = input.closest('.cms-image-control');
        const preview = control?.querySelector('img');

        if (!file || !preview) {
            return;
        }

        preview.src = URL.createObjectURL(file);
    });
});
