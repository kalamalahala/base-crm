export const setVis = (elementToToggle, isVisible) => {
    const $ = jQuery;
    let toggleMode = isVisible ? 'removeClass' : 'addClass';
    $(`.${elementToToggle}`)[toggleMode]('d-none');
    // console.log(`setVis: ${elementToToggle} is now ${isVisible ? 'visible' : 'hidden'}.`);
    return isVisible;
}