// filterrange
var start = moment().subtract(29, "days");
var end = moment();

function newDateRHMJJK(start, end) {
    $("#filterrange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
}
$("#filterrange").daterangepicker({
        startDate: start,
        endDate: end,
        showDropdowns: true,
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf(
                "month")],
        },
    },
    newDateRHMJJK
);
newDateRHMJJK(start, end);


// Internationalization (Language Dropdown)
// ---------------------------------------

if (typeof i18next !== "undefined" && typeof i18NextHttpBackend !== "undefined") {
    i18next
        .use(i18NextHttpBackend)
        .init({
            lng: "en",
            debug: false,
            fallbackLng: "en",
            backend: {
                loadPath: assetsPath + "json/locales/{{lng}}.json",
            },
            returnObjects: true,
        })
        .then(function (t) {
            localize();
        });
}

let languageDropdown = document.getElementsByClassName("dropdown-language");

if (languageDropdown.length) {
    let dropdownItems = languageDropdown[0].querySelectorAll(".dropdown-item");

    for (let i = 0; i < dropdownItems.length; i++) {
        dropdownItems[i].addEventListener("click", function () {
            let currentLanguage = this.getAttribute("data-language"),
                selectedLangFlag = this.querySelector(".fi").getAttribute("class");

            for (let sibling of this.parentNode.children) {
                sibling.classList.remove("selected");
            }
            this.classList.add("selected");

            languageDropdown[0].querySelector(".dropdown-toggle .fi").className = selectedLangFlag;

            i18next.changeLanguage(currentLanguage, (err, t) => {
                if (err) return console.log("something went wrong loading", err);
                localize();
            });
        });
    }
}

function localize() {
    let i18nList = document.querySelectorAll("[data-i18n]");
    // Set the current language in dd
    let currentLanguageEle = document.querySelector('.dropdown-item[data-language="' + i18next.language + '"]');

    if (currentLanguageEle) {
        currentLanguageEle.click();
    }

    i18nList.forEach(function (item) {
        item.innerHTML = i18next.t(item.dataset.i18n);
    });
}




(function ($) {
    "use strict";
    var tableBasic = {
      initialize: function () {
        this.basic();
        this.enableDisable();
        this.ordering();
        this.multiColumnOrdering();
        this.multipleTables();
        this.hiddenColumns();
        this.complexHeaders();
        this.domPositioning();
        this.alternativePagination();
        this.scrollVertical();
        this.dynamicHeight();
        this.scrollHorizontal();
        this.scrollHorizontalVertical();
        this.languageCommaDecimalPlace();
        this.languageOptions();
      },
      basic: function () {
        $(".basic").DataTable({
          iDisplayLength: 6,
          ordering: false,
          scrollCollapse: true,
          lengthMenu: [
            [6, 10, 25, 50, -1],
            [6, 10, 25, 50, "All"],
          ],
          scrollY: "256px",
          language: {
            oPaginate: {
              sNext: '<i class="ti-angle-right"></i>',
              sPrevious: '<i class="ti-angle-left"></i>',
            },
          },
        });
      },
    };
    // Initialize
    $(document).ready(function () {
      "use strict"; // Start of use strict
      tableBasic.initialize();
    });
  })(jQuery);

  (function ($) {
    "use strict";
    var tableBasic = {
      initialize: function () {
        this.basic();
        this.enableDisable();
        this.ordering();
        this.multiColumnOrdering();
        this.multipleTables();
        this.hiddenColumns();
        this.complexHeaders();
        this.domPositioning();
        this.alternativePagination();
        this.scrollVertical();
        this.dynamicHeight();
        this.scrollHorizontal();
        this.scrollHorizontalVertical();
        this.languageCommaDecimalPlace();
        this.languageOptions();
      },
      basic: function () {
        $(".basicone").DataTable({
          iDisplayLength: 6,
          scrollCollapse: true,
          scrollY: "256px",
          ordering: false,
          lengthMenu: [
            [6, 10, 25, 50, -1],
            [6, 10, 25, 50, "All"],
          ],
          language: {
            oPaginate: {
              sNext: '<i class="ti-angle-right"></i>',
              sPrevious: '<i class="ti-angle-left"></i>',
            },
          },
        });
      },
    };
    // Initialize
    $(document).ready(function () {
      "use strict"; // Start of use strict
      tableBasic.initialize();
    });
  })(jQuery);




// new dashboard end
