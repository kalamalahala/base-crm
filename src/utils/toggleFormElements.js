/**
 * Enables or disables form elements within a parent element
 * 
 * @param {string} parent Parent element of form elements to toggle
 * @param {boolean} toggleMode true to disable, false to enable
 */
export const toggleFormElements = (parent, toggleMode) => {
    const $ = jQuery;
    let inputs = $(parent).find('input, select, textarea, button');
    inputs.each((index, element) => {
        $(element).attr('disabled', toggleMode);
    }
    );
}