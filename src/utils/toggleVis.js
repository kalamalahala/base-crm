/**
 * Get current visibility state of an element and toggle it
 * 
 * @param {string} elementToToggle HTML element to show or hide
 * @returns {boolean} true if element is now visible, false if now hidden
 */
export const toggleVis = (elementToToggle) => {
    const $ = jQuery;
    let isVisible = $(elementToToggle).hasClass('d-none');
    let toggleMode = isVisible ? 'removeClass' : 'addClass';
    $(elementToToggle)[toggleMode]('d-none');

    return !isVisible;
}