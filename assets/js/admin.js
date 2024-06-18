function copyShortcode() {
    // Get the shortcode text
    var shortcodeText = document.getElementById('shortcode-sm-render').innerText;

    // Create a temporary input element
    var tempInput = document.createElement('input');
    tempInput.value = shortcodeText;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    // Show the snackbar
    var snackbar = document.getElementById('snackbar');
    snackbar.className = 'show';
    setTimeout(function() { snackbar.className = snackbar.className.replace('show', ''); }, 3000);
}

jQuery(document).ready(function($) {
    $('.nav-tab').click(function(e) {
        e.preventDefault();
        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');

        $('.tab-content').hide();
        $($(this).attr('href')).show();
    });
});