import "./bootstrap";

//Sidebar
window.toggleAdminMenu = function () {
    const menu = document.getElementById("adminMenu");
    const arrow = document.getElementById("adminArrow");

    menu.classList.toggle("hidden");
    arrow.classList.toggle("rotate-180");
};

//Search
window.toggleSearch = function () {
    const input = document.getElementById("searchInput");

    if (input.classList.contains("w-0")) {
        input.classList.remove("w-0", "opacity-0");
        input.classList.add("w-64", "opacity-100", "mr-2");
    } else {
        input.classList.add("w-0", "opacity-0");
        input.classList.remove("w-64", "opacity-100", "mr-2");
    }
};

//Status
window.toggleStatus = async function (button) {
    if (!confirm("Bạn có chắc muốn thay đổi trạng thái?")) return;

    const url = button.dataset.url;

    try {
        const response = await fetch(url, {
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                Accept: "application/json",
            },
        });

        const data = await response.json();

        if (data.success) {
            const isActive = data.status == 1;

            button.classList.toggle("text-green-600", isActive);
            button.classList.toggle("text-gray-400", !isActive);

            button
                .querySelector(".eye-open")
                .classList.toggle("hidden", !isActive);
            button
                .querySelector(".eye-close")
                .classList.toggle("hidden", isActive);
        }
    } catch (error) {
        alert("Có lỗi xảy ra!");
    }
};
