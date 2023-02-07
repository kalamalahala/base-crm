const $ = jQuery;
const ajaxUrl = base_crm.ajax_url;
const ajaxNonce = base_crm.ajax_nonce;
const ajaxAction = base_crm.ajax_action;
import * as Papa from "papaparse";

export const bulkUpload = () => {
    const bulkUploadForm = $("#bulk-upload-form");
    const fileInput = bulkUploadForm.find("input[type='file']");
    const submitButton = bulkUploadForm.find("button[type='submit']");
    const submitCurrentHTML = submitButton.html();

    const displayUpload = $(".upload-contents");

    bulkUploadForm.on("submit", (e) => {
        e.preventDefault();
        // console.log("submitting: ", bulkUploadForm.serializeArray());
        submitButton.html("Uploading...");
        submitButton.prop("disabled", true);

        let data = new FormData(bulkUploadForm[0]);
        data.append("action", ajaxAction);
        data.append("nonce", ajaxNonce);
        data.append("method", "bulk_upload_leads");

        let parse = Papa.parse(fileInput[0].files[0], {
            header: true,
            complete: (results) => {
                let csvData = results.data;
                let count = csvData.length;

                data.append("csvData", JSON.stringify(csvData));

                $.ajax({
                    url: ajaxUrl,
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        if (response.success) {
                            submitButton.html(submitCurrentHTML);
                            submitButton.prop("disabled", false);
                            displayUpload.html("");
                            fileInput.val("");
                            let totalCount = count - response.errors.length;
                            let successAlert = "";
                            if (totalCount > 0) {
                                successAlert = `<div class="alert alert-success" role="alert">Successfully uploaded ${totalCount} leads.</div>`;
                            }
                            let errorAlert = "";
                            if (response.errors.length > 0) {
                                errorAlert = `<div class="alert alert-danger" role="alert">Failed to upload ${response.errors.length} leads.
                                <ul>
                                    ${response.errors.map((error) => {
                                        let errorString = "";
                                        for (let key in error.error) {
                                            errorString += `${error.error[key]}`;
                                        }
                                        return `<li><strong>${error.row['Applicant Name (First)']} ${error.row['Applicant Name (Last)']}</strong>: ${errorString}</li>`;
                                    }).join('')}
                                </ul></div>`;
                            }

                            displayUpload.html(`
                                ${successAlert}
                                ${errorAlert}
                            `);
                        } else {
                            submitButton.html(submitCurrentHTML);
                            submitButton.prop("disabled", false);
                            alert(response.errors);
                        }
                    },
                    error: (response) => {
                        // console.log("response: ", response.errors);
                        submitButton.html(submitCurrentHTML);
                        submitButton.prop("disabled", false);
                        alert(response.errors);
                    },
                });
            },
        });

    });

    submitButton.on("click", (e) => {
        e.preventDefault();
        const file = bulkUploadForm.find("input[type='file']").val();
        // console.log("file: ", file);

        if (!file) {
            alert("Please select a file to upload.");
            return;
        }

        bulkUploadForm.submit();
    });

    fileInput.on("change", (e) => {
        const file = e.target.files[0];
        // console.log("file: ", file);

        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            const csv = e.target.result;
            // console.log("csv: ", csv);

            Papa.parse(csv, {
                header: true,
                complete: (results) => {
                    let data = results.data;
                    let count = data.length;

                    displayUpload.html(`
                        <div class='row'>
                            <div class='col-12'>
                                <h3>Upload Preview</h3>
                                <p>Review the data below to ensure it is correct before uploading.</p>
                                </div>
                                </div>
                                <div class='row'>
                                    
                                    <div class='col-12' style='overflow-y:scroll; max-height:45vh;'>
                                        <table class='table table-striped'>
                                            <thead>
                                                <tr>
                                                    <th>Appointment Date</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>No-Cost Offer</th>
                                                    <th>Phone</th>
                                                    <th>Sale?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${data
                                                    .map((row) => {
                                                        return `
                                                        <tr>
                                                            <td>${row["Entry Date"]}</td>
                                                            <td>${row["Applicant Name (First)"]}</td>
                                                            <td>${row["Applicant Name (Last)"]}</td>
                                                            <td>${row["Select Which No-Cost Offer Used"]}</td>
                                                            <td>${row["Client Phone Number"]}</td>
                                                            <td>${row["Was there a Sale?"]}</td>
                                                        </tr>`;
                                                    })
                                                    .join("")}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <p><strong>${count}</strong> records will be uploaded.</p>
                                    </div>
                                </div>
                            </div>
                        </div>`);
                },
            });
        };

        reader.readAsText(file);
    });
};
