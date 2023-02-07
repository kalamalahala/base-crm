import "bootstrap";
import "./_custom.scss";
import "./style.css";
import { leadTable } from "./tables/leadTable";
import { createLeadForm } from "./forms/createLeadForm";
import { appointmentTable } from "./tables/appointmentTable";
import { modalCreateLeadForm } from "./forms/modalCreateLeadForm";
import { dtButtonListeners } from "./tables/dtButtonListeners";
import { callLeadModalHandler } from "./forms/modalCallLead";
import { presentationForm } from "./forms/presentationForm";
import { adminTable } from "./tables/adminTable";
import { bulkUpload } from "./forms/bulkUpload";
import { referralsForm } from "./forms/referralsForm";
const $ = jQuery;
const currentPage = base_crm.current_page;

$(document).ready(function () {
    const loadLeadTable = () => {
        if (currentPage.includes("/base/leads/")) {
            leadTable();
            callLeadModalHandler();
            createLeadForm();
            dtButtonListeners();
        }
    };

    const loadAppointmentTable = () => {
        if (currentPage.includes("/base/appointments/")) {
            appointmentTable();
            dtButtonListeners();
        }
    };

    const loadAdminTable = () => {
        if (currentPage.includes("/base/settings/")) {
            adminTable();
            dtButtonListeners();
            bulkUpload();
        }
    };

    loadLeadTable();
    loadAppointmentTable();
    loadAdminTable();
    modalCreateLeadForm();
    presentationForm();
    referralsForm();
});