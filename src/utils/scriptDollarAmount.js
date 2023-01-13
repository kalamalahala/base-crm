export const scriptDollarAmount = (amount) => {
    // return false if amount is not a number
    if (isNaN(amount)) return false;
    let prefix = "";
    if (amount <= 0) {
        prefix = "-";
    }
    // convert amount to string
    amount = amount.toString();
    // split amount into whole and decimal parts
    let parts = amount.split(".");
    // add commas to whole part
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // return formatted amount
    return `${prefix}$${parts.join(".")}`;
};