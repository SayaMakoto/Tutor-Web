import "./bootstrap";

// Toggle dropdown
function toggleDropdown(name) {
    // đóng tất cả trước
    document
        .querySelectorAll('[id$="Menu"]')
        .forEach((el) => el.classList.add("hidden"));

    // mở cái hiện tại
    document.getElementById(name + "Menu").classList.toggle("hidden");
}

// Chọn option
function selectOption(name, value) {
    document.getElementById(name + "Selected").innerText = value;
    document.getElementById(name + "Value").value = value;

    document.getElementById(name + "Menu").classList.add("hidden");
}

// Search filter
function filterDropdown(name) {
    let input = document.getElementById(name + "Search").value.toLowerCase();
    let items = document.querySelectorAll(`#${name}List .dropdown-item`);

    items.forEach((item) => {
        let text = item.innerText.toLowerCase();
        item.style.display = text.includes(input) ? "" : "none";
    });
}

// Click ngoài → đóng dropdown
document.addEventListener("click", function (e) {
    document.querySelectorAll('[id$="Dropdown"]').forEach((dropdown) => {
        if (!dropdown.contains(e.target)) {
            let menu = dropdown.querySelector('[id$="Menu"]');
            if (menu) menu.classList.add("hidden");
        }
    });
});
