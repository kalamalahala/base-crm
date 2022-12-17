import "bootstrap";
import "./_custom.scss";
import "./style.css";
import { leadTable } from "./tables/leadTable";
import { createLeadForm } from "./forms/createLeadForm";
import { appointmentTable } from "./tables/appointmentTable";
import { modalCreateLeadForm } from "./forms/modalCreateLeadForm";
import { dtButtonListeners } from "./tables/dtButtonListeners";
import { callLeadModalHandler } from "./forms/modalCallLead";
const $ = jQuery;
const currentPage = base_crm.current_page;

console.log(currentPage);

$(document).ready(function () {
    const loadLeadTable = () => {
        if (currentPage === "/base/leads/") {
            leadTable();
            callLeadModalHandler();
            createLeadForm();
            dtButtonListeners();
        }
    };

    const loadAppointmentTable = () => {
        if (currentPage === "/base/appointments/") {
            appointmentTable();
        }
    };

    loadLeadTable();
    loadAppointmentTable();
    modalCreateLeadForm();
});
