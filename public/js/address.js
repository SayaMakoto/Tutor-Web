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

    studyRadios.forEach((radio) => {
        radio.addEventListener("change", function () {
            if (!addressSection) return;

            if (this.value === "offline") {
                addressSection.classList.remove("hidden");
            } else {
                addressSection.classList.add("hidden");
            }
        });
    });
};
