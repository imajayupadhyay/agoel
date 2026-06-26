const headerList = document.querySelector('[data-header-items]');
const headerTemplate = document.querySelector('[data-header-template]');

const refreshHeaderItems = () => {
    if (!headerList) return;

    [...headerList.querySelectorAll('[data-header-item]')].forEach((item, index) => {
        item.querySelector('[data-item-label]').textContent = `Nav item ${index + 1}`;
        item.querySelector('[data-header-field="sort_order"]').value = String((index + 1) * 10);
        item.querySelectorAll('[name]').forEach((input) => {
            input.name = input.name.replace(/nav_items\[[^\]]+\]/, `nav_items[${index}]`);
        });
    });
};

document.querySelector('[data-add-header-item]')?.addEventListener('click', () => {
    if (!headerList || !headerTemplate) return;

    const index = headerList.querySelectorAll('[data-header-item]').length;
    headerList.insertAdjacentHTML('beforeend', headerTemplate.innerHTML.replaceAll('__INDEX__', String(index)));
    refreshHeaderItems();
});

headerList?.addEventListener('click', (event) => {
    const item = event.target.closest('[data-header-item]');

    if (!item) return;

    if (event.target.closest('[data-header-remove]')) {
        item.remove();
        refreshHeaderItems();
    }

    if (event.target.closest('[data-header-move-up]') && item.previousElementSibling) {
        item.parentElement.insertBefore(item, item.previousElementSibling);
        refreshHeaderItems();
    }

    if (event.target.closest('[data-header-move-down]') && item.nextElementSibling) {
        item.parentElement.insertBefore(item.nextElementSibling, item);
        refreshHeaderItems();
    }
});

refreshHeaderItems();
