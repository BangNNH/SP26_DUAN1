document.addEventListener("click", function (e) {
    const btn = e.target.closest("button");
    if (!btn) return;

    const id = btn.dataset.id;
    if (!id) return;

    let action = null;

    if (btn.classList.contains("btn-increase-session")) action = "increase";
    if (btn.classList.contains("btn-subtract-session")) action = "decrease";
    if (btn.classList.contains("btn-delete-pd-session")) action = "delete";

    if (!action) return;

    fetch("?act=ajax-cart-session", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            san_pham_id: id,
            action: action
        })
    })
        .then(res => res.text()) // 🔥 đổi để debug
        .then(data => {
            console.log("RESPONSE:", data);
            try {
                const json = JSON.parse(data);
                if (json.success) {
                    updateCartUI(id, json);
                }
            } catch (e) {
                console.error("JSON ERROR:", e);
            }
        });
});

function updateCartUI(id, data) {
    const input = document.querySelector(`.qty-input[data-id='${id}']`);

    if (!input) return;

    if (data.so_luong > 0) {
        input.value = data.so_luong;
    } else {
        const item = input.closest(".minicart-item");
        if (item) item.remove();
    }

    document.querySelector("#tam-tinh").innerText = data.tamTinh;
    document.querySelector("#giam-gia").innerText = data.giamGia;
    document.querySelector("#thanh-toan").innerText = data.thanhToan;

    const emptyBox = document.querySelector("#empty-cart");
    const summaryBox = document.querySelector("#cart-summary");

    if (data.isEmpty) {
        emptyBox.style.display = "block";
        summaryBox.style.display = "none";
    } else {
        emptyBox.style.display = "none";
        summaryBox.style.display = "block";
    }
}
// document.querySelector("#cart-count").innerText = Object.keys(data.cart || {}).length;
// e.target.disabled = true;
// setTimeout(() => e.target.disabled = false, 300);