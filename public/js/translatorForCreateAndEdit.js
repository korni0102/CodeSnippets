function getTranslation(button) {
    let readInput = button.parent().parent().find('input');

    if (readInput.length === 0){
        readInput = button.parent().parent().find('textarea');
    }

    const fromLanguage = button.data('local');
    const toLanguage = fromLanguage === "en" ? "sk" : "en";
    const value = readInput.val();
    const writeInput = $('#' + button.data('target-id'));

    openGoogleTranslator
        .TranslateLanguageData({
            listOfWordsToTranslate: [value],
            fromLanguage: fromLanguage,
            toLanguage: toLanguage,
        })
        .then((data) => {
            writeInput.val(data[0].translation);
        });
}
