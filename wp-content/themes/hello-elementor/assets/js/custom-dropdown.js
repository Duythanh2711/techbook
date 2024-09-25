document.addEventListener("DOMContentLoaded", function() {
    var currencyBtn = document.getElementById("currency-btn");
    var currencyDropdown = document.getElementById("currency-dropdown");
    var currencySwitch = document.getElementById("currency-switch");

    var languageBtn = document.getElementById("language-btn");
    var languageDropdown = document.getElementById("language-dropdown");
    var languageSwitch = document.getElementById("language-switch");

    // Currency toggle
    currencyBtn.addEventListener("click", function() {
        currencyDropdown.style.display = currencyDropdown.style.display === "block" ? "none" : "block";
    });

    currencySwitch.addEventListener("click", function() {
        if (currencyBtn.innerText.includes("USD")) {
            currencyBtn.innerHTML = 'VND <img src="' + appPath + '/wp-content/uploads/2024/09/Symbol.svg" alt="Dropdown Icon" class="dropdown-icon">';
            currencySwitch.innerText = "USD";
        } else {
            currencyBtn.innerHTML = 'USD <img src="' + appPath + '/wp-content/uploads/2024/09/Symbol.svg" alt="Dropdown Icon" class="dropdown-icon">';
            currencySwitch.innerText = "VND";
        }
        currencyDropdown.style.display = "none";
    });

    // Language toggle
    languageBtn.addEventListener("click", function() {
        languageDropdown.style.display = languageDropdown.style.display === "block" ? "none" : "block";
    });

    languageSwitch.addEventListener("click", function() {
        if (languageBtn.innerText.includes("English")) {
            languageBtn.innerHTML = 'Vietnamese <img src="' + appPath + '/wp-content/uploads/2024/09/Symbol.svg" alt="Dropdown Icon" class="dropdown-icon">';
            languageSwitch.innerText = "English";
        } else {
            languageBtn.innerHTML = 'English <img src="' + appPath + '/wp-content/uploads/2024/09/Symbol.svg" alt="Dropdown Icon" class="dropdown-icon">';
            languageSwitch.innerText = "Vietnamese";
        }
        languageDropdown.style.display = "none";
    });

    // Đóng dropdown khi nhấn ra ngoài
    document.addEventListener("click", function(event) {
        if (!currencyBtn.contains(event.target) && !currencyDropdown.contains(event.target)) {
            currencyDropdown.style.display = "none";
        }
        if (!languageBtn.contains(event.target) && !languageDropdown.contains(event.target)) {
            languageDropdown.style.display = "none";
        }
    });
});
