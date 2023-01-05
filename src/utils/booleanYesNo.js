export const booleanYesNo = (bool) => {
    if (bool === 1 || bool === true) {
        return "Yes";
    } else {
        return "No";
    }
};

export const yesNoFieldToBoolean = (value) => {
    if (value === "Yes") {
        return true;
    } else {
        return false;
    }
};