window.AddressAPI = function ({
    provinceSelector,
    wardSelector,
    detailSelector,
    fullAddressSelector,
}) {
    const province = document.querySelector(provinceSelector);
    const ward = document.querySelector(wardSelector);
    const detail = document.querySelector(detailSelector);
    const fullAddress = document.querySelector(fullAddressSelector);

    if (!province || !ward) return;

    const setOptions = (select, list, placeholder) => {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        list.forEach((item) => {
            select.innerHTML += `
                <option value="${item.name}" data-code="${item.code}">
                    ${item.name}
                </option>`;
        });
        select.disabled = false;
    };

    function updateFullAddress() {
        if (!fullAddress) return;

        const d = detail?.value || "";
        const w = ward?.value || "";
        const p = province?.value || "";

        fullAddress.value = [d, w, p].filter(Boolean).join(", ");
    }

    detail?.addEventListener("input", updateFullAddress);
    ward.addEventListener("change", updateFullAddress);
    province.addEventListener("change", updateFullAddress);

    fetch("https://provinces.open-api.vn/api/v2/p/")
        .then((res) => res.json())
        .then((data) => setOptions(province, data, "Chọn tỉnh"));

    province.addEventListener("change", function () {
        const code = this.selectedOptions[0]?.dataset.code;

        ward.innerHTML = `<option>Đang tải...</option>`;
        ward.disabled = true;

        if (!code) return;

        fetch(`https://provinces.open-api.vn/api/v2/p/${code}?depth=2`)
            .then((res) => res.json())
            .then((data) => {
                setOptions(ward, data.wards || [], "Chọn phường");
            });
    });

    const addressSection = document.getElementById("addressSection");
    const studyRadios = document.querySelectorAll("input[name='study_type']");

    if (addressSection) {
        const inputs = addressSection.querySelectorAll("select, input");

        const updateAddressSectionState = () => {
            const checkedRadio = document.querySelector("input[name='study_type']:checked");
            if (!checkedRadio) return;

            if (checkedRadio.value === "offline") {
                addressSection.classList.remove("opacity-50", "pointer-events-none");
                inputs.forEach(input => {
                    if (input.id !== "full_address") {
                        input.removeAttribute("disabled");
                    }
                });
            } else {
                addressSection.classList.add("opacity-50", "pointer-events-none");
                inputs.forEach(input => {
                    input.setAttribute("disabled", "true");
                });
            }
        };

        // Listen for changes
        studyRadios.forEach((radio) => {
            radio.addEventListener("change", updateAddressSectionState);
        });

        // Initialize state on page load
        updateAddressSectionState();
    }
};
