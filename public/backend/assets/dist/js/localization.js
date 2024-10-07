"use strict";
// document ready
$(function () {
    fetchAndStoreLocalizationStrings();
    // find localize class and replace the text with localized text
    $(".localize").each(function () {
        $(this).text(get_phrases($(this).text()));
    });
});

/**
 * Fetch the localization strings from the server and store them in local storage
 */
function fetchAndStoreLocalizationStrings() {
    const localization = getLocalization();

    if (!localization || Object.keys(localization).length === 0) {
        fetch($("meta[name='get-localization-strings']").attr("content"))
            .then((response) => response.json())
            .then((data) => {
                // Store the localization strings in local storage
                localStorage.setItem(
                    getLocalizationName(),
                    JSON.stringify(data)
                );
            })
            .catch((error) => {
                console.error("Error fetching localization strings.");
            });
    }
}

/**
 * gel all localization strings from local storage
 * @returns {object}
 */
function getLocalization() {
    const localization = localStorage.getItem(getLocalizationName());
    if (localization) {
        return JSON.parse(localization);
    }
    // return blank object if no localization is found
    return {};
}

/**
 * Get the localization name from the meta tag
 * @returns {string}
 */
function getLocalizationName() {
    const localName = $("meta[name='default-localization']").attr("content");
    return "localization_" + localName.replace(/ /g, "_");
}

/**
 * Get the localized phrases for the given key
 * @param {string} key
 * @returns {string}
 */
function get_phrases(key) {
    const localization = getLocalization();
    // and to lowercase
    key = key.trim().replace(/ /g, "_").toLowerCase();
    // localization not empty
    if (localization && Object.keys(localization).length > 0) {
        if (localization[key]) {
            return localization[key];
        }
        addLocalizationKey(key);
    }
    // If the key is not found, remove underscores and return the uppercase first letter
    return key.replace(/_/g, " ").replace(/^\w/, (c) => c.toUpperCase());
}

/**
 * Get the localized phrases for the given key
 * @param {string} key
 * @returns {string}
 */
function localize(key) {
    return get_phrases(key);
}

// Function to add a new localization key on the server
function addLocalizationKey(key) {
    const url = $("meta[name='get-localization-strings']").attr("content");

    var value = key.replace(/_/g, " ").replace(/^\w/, (c) => c.toUpperCase());
    const data = { key: key, value: value };
    console.log(JSON.stringify(data));
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
        },
        body: JSON.stringify(data),
        // add csrf from meta
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.data) {
                localStorage.setItem(
                    getLocalizationName(),
                    JSON.stringify(result.data)
                );
            }
        })
        .catch((error) => {
            console.error("Error adding localization key.");
        });
}
