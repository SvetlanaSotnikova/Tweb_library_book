
    const radios = document.querySelectorAll('input[name="favorites_season"]');
    const blocks = document.querySelectorAll('.season-block');

    radios.forEach(radio => {
        radio.addEventListener('change', (event) => {
            // Скрываем все блоки
            blocks.forEach(block => block.style.display = 'none');

            // Показываем соответствующий блок
            const selectedValue = event.target.value;
            const blockToShow = document.getElementById(`block-${selectedValue.toLowerCase()}`);
            if (blockToShow) {
                blockToShow.style.display = 'block';
            }
        })
    })