$(document).ready(function () {
    "use strict"; // Start of use strict
    document.querySelectorAll(".tooltip-test").forEach(function (tooltip) {
        new bootstrap.Tooltip(tooltip);
    });
    document.querySelectorAll(".popover-test").forEach(function (popover) {
        new bootstrap.Popover(popover);
    });
    var exampleModal = document.getElementById("VaryingModal");
    if (VaryingModal) {
        VaryingModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget;
            var recipient = button.getAttribute("data-bs-whatever");
            var modalTitle = VaryingModal.querySelector(".modal-title");
            var modalBodyInput = VaryingModal.querySelector(".modal-body input");
            modalTitle.textContent = "New message to " + recipient;
            modalBodyInput.value = recipient;
        });
    }
});