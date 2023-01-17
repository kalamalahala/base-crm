/**
 * Show or hide loading overlay
 * @param {string} text Loading text
 * @param {boolean} visibility 
 */
export const setLoadingOverlay = (text, visibility) => {
    const $ = jQuery;
    $('.loading-text').text(text);
    if (visibility) {
        $('.lead-table-loading-overlay').removeClass('d-none');
    } else if (visibility === false) {
        $('.lead-table-loading-overlay').addClass('d-none');
    }
};