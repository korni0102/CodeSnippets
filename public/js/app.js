function copyToClipboard(text, element){
    navigator.clipboard.writeText(text).then(() => {
        const clickedButton = element[0];

        clickedButton.innerHTML = `<i class="bi bi-clipboard-check"></i>`;
        setTimeout(() => {
            clickedButton.innerHTML = `<i class="bi bi-clipboard"></i>`;
        }, 1000);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}

function changeLinkColor(elem) {
    // Remove "link-primary" from all links, add "link-secondary"
    $('a').removeClass('link-primary').addClass('link-secondary');
    // Add "link-primary" to the clicked link
    elem.removeClass('link-secondary').addClass('link-primary');
}

function updateLinkOnScroll() {
    $('h3[id]').each(function () {
        const section = $(this);
        const sectionId = `#${section.attr('id')}`;
        const sectionOffset = section.offset().top;
        const sectionHeight = section.outerHeight();
        const scrollPosition = $(window).scrollTop();


        if (scrollPosition >= sectionOffset - 100 && scrollPosition < sectionOffset + sectionHeight) {
            window.history.replaceState(null, null, sectionId);

            $('a').each(function () {
                const link = $(this);
                if (link.attr('href') === sectionId) {
                    link.removeClass('link-secondary').addClass('link-primary');
                } else {
                    link.removeClass('link-primary').addClass('link-secondary');
                }
            });
        }
    });
}

$(window).on('scroll', updateLinkOnScroll);


$(document).ready(function () {
    updateLinkOnScroll();
});

