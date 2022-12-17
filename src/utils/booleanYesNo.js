export const booleanYesNo = (bool) => {
    if (bool === 1 || bool === true) {
        return "Yes";
    } else {
        return "No";
    }
};