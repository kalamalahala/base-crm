export const visHandle = (inputClicked) => {
    const $ = jQuery;
    const element = $(inputClicked);
    const data = element.data();

    if (data.visShow) {
        $(`.${data.visShow}`).removeClass("d-none");
        console.log(`Displaying ${data.visShow}`);
    } else if (data.visHide) {
        $(`.${data.visHide}`).addClass("d-none");
        console.log(`Hiding ${data.visHide}`);
    }
};
