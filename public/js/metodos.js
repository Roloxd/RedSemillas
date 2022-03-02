function newOption(value, text) {
    const option = document.createElement('OPTION');
    option.value = value;
    option.textContent = text;

    return option;
}