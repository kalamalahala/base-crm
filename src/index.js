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
import { clientsTable } from "./tables/clientsTable";
import { ajaxTestingZone } from "./utils/ajaxTestingZone";

const $ = jQuery;
const currentPage = base_crm.current_page;

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
            dtButtonListeners();
        }
    };

    const loadAdminTable = () => {
        console.log('current page: ', currentPage);
        if (currentPage === "/base/settings/") {
            console.log("admin table");
            adminTable();
            dtButtonListeners();
        }
    };

    const loadClientsTable = () => {
        if (currentPage === "/base/clients/") {
            clientsTable();
            dtButtonListeners();
        }
    };

    loadLeadTable();
    loadAppointmentTable();
    loadAdminTable();
    modalCreateLeadForm();
    presentationForm();
    loadClientsTable();
    ajaxTestingZone();
});
