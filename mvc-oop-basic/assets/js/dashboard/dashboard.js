document.addEventListener("DOMContentLoaded", function () {
  const labelsContainer = document.querySelector(".chart-labels");
  const buttons = document.querySelectorAll(".chart-filter button");
  const svg = document.querySelector(".chart-container svg");

  // Placeholder tooltip
  let tooltip = document.createElement("div");
  tooltip.id = "chart-tooltip";
  tooltip.style.position = "absolute";
  tooltip.style.background = "#111";
  tooltip.style.color = "#fff";
  tooltip.style.padding = "4px 8px";
  tooltip.style.fontSize = "12px";
  tooltip.style.borderRadius = "4px";
  tooltip.style.display = "none";
  tooltip.style.pointerEvents = "none";
  document.body.appendChild(tooltip);

  const data7Ngay = window.data7Ngay || [];
  const data12Thang = window.data12Thang || [];

  function getDateKey(dateStr) {
    return new Date(dateStr).toISOString().slice(0, 10);
  }

  function getLast7DaysData() {
    const today = new Date();
    const map = new Map();
    data7Ngay.forEach((item) => {
      const key = getDateKey(item.ngay);
      map.set(key, Number(item.doanh_thu || 0));
    });

    let result = [];
    for (let i = 6; i >= 0; i--) {
      const d = new Date(today);
      d.setDate(today.getDate() - i);
      const key = d.toISOString().slice(0, 10);
      result.push({
        label: String(d.getDate()),
        value: map.has(key) ? map.get(key) : 0,
        key,
      });
    }

    return result;
  }

  function getCurrentWeekData() {
    const dayNames = ["T2", "T3", "T4", "T5", "T6", "T7", "CN"];
    const weekStart = new Date();
    const day = weekStart.getDay();

    // convert Sunday(0) to end
    const offset = day === 0 ? 6 : day - 1;
    weekStart.setDate(weekStart.getDate() - offset);

    const map = new Map();
    data7Ngay.forEach((item) => {
      const key = getDateKey(item.ngay);
      map.set(key, Number(item.doanh_thu || 0));
    });

    let result = [];
    for (let i = 0; i < 7; i++) {
      const d = new Date(weekStart);
      d.setDate(weekStart.getDate() + i);
      const key = d.toISOString().slice(0, 10);
      result.push({
        label: dayNames[i],
        value: map.has(key) ? map.get(key) : 0,
        key,
      });
    }

    return result;
  }

  function getLast12MonthsData() {
    const monthMap = new Map();
    data12Thang.forEach((item) => {
      monthMap.set(Number(item.thang), Number(item.doanh_thu || 0));
    });

    let result = [];
    const currentYear = new Date().getFullYear();

    for (let m = 1; m <= 12; m++) {
      const paddedMonth = String(m).padStart(2, "0");
      result.push({
        label: "Th" + m,
        value: monthMap.has(m) ? monthMap.get(m) : 0,
        key: currentYear + "-" + paddedMonth,
      });
    }

    return result;
  }

  function renderLabels(data) {
    if (!labelsContainer) return;
    labelsContainer.innerHTML = data
      .map((item) => "<span>" + item.label + "</span>")
      .join("");
  }

  function drawChart(data) {
    if (!data || data.length === 0) {
      if (svg) {
        const line = svg.querySelector(".line-chart");
        const area = svg.querySelector(".area-chart");
        if (line) line.setAttribute("d", "M0,40 L100,40");
        if (area) area.setAttribute("d", "M0,40 L100,40 L0,40 Z");
      }
      return;
    }

    const max = Math.max(...data.map((d) => d.value), 1);
    const stepX = data.length > 1 ? 100 / (data.length - 1) : 100;

    let path = "";
    data.forEach((point, index) => {
      const x = index * stepX;
      const y = 40 - (point.value / max) * 30;
      if (index === 0) {
        path = "M" + x + "," + y;
      } else {
        path += " L" + x + "," + y;
      }
    });

    const lineEl = svg.querySelector(".line-chart");
    const areaEl = svg.querySelector(".area-chart");
    if (lineEl) lineEl.setAttribute("d", path);
    if (areaEl) areaEl.setAttribute("d", path + " L100,40 L0,40 Z");

    svg.querySelectorAll(".dot").forEach((dot) => dot.remove());

    data.forEach((point, index) => {
      const x = index * stepX;
      const y = 40 - (point.value / max) * 30;

      const circle = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "circle",
      );
      circle.setAttribute("cx", x);
      circle.setAttribute("cy", y);
      circle.setAttribute("r", "1.5");
      circle.setAttribute("fill", "#b70011");
      circle.classList.add("dot");

      circle.addEventListener("mousemove", (e) => {
        tooltip.style.display = "block";
        tooltip.style.left = e.pageX + 10 + "px";
        tooltip.style.top = e.pageY - 20 + "px";
        tooltip.innerHTML =
          point.label + "<br>" + point.value.toLocaleString() + " đ";
      });

      circle.addEventListener("mouseleave", () => {
        tooltip.style.display = "none";
      });

      svg.appendChild(circle);
    });
  }

  function loadChart(type = "day") {
    let chartData = [];

    if (type === "day") {
      chartData = getLast7DaysData();
    } else if (type === "week") {
      chartData = getCurrentWeekData();
    } else if (type === "month") {
      chartData = getLast12MonthsData();
    }

    renderLabels(chartData);
    drawChart(chartData);
  }

  buttons.forEach((btn) => {
    btn.addEventListener("click", function () {
      buttons.forEach((b) => b.classList.remove("active", "bg-red-light"));
      this.classList.add("active", "bg-red-light");
      loadChart(this.dataset.type);
    });
  });

  const filterBtn = document.getElementById("filterBtn");
  if (filterBtn) {
    filterBtn.addEventListener("click", async function () {
      const from = document.getElementById("dateFrom").value;
      const to = document.getElementById("dateTo").value;
      if (!from || !to) {
        alert("Chọn ngày!");
        return;
      }

      try {
        const res = await fetch(
          window.ADMIN_URL + "?act=thong-ke-filter&from=" + from + "&to=" + to,
        );
        const data = await res.json();
        updateDashboard(data, from, to);
        closeModal();

        const mainDashboard = document.getElementById("mainDashboard");
        const filteredDashboard = document.getElementById("filteredDashboard");
        if (mainDashboard) mainDashboard.style.display = "none";
        if (filteredDashboard) filteredDashboard.style.display = "block";
      } catch (err) {
        console.error("Lỗi:", err);
      }
    });
  }

  function updateDashboard(data, from, to) {
    const filtered = document.getElementById("filteredDashboard");

    filtered.querySelector(".doanh-thu").innerText = Number(
      data.doanh_thu || 0,
    ).toLocaleString();
    filtered.querySelector(".don-moi").innerText = data.don_moi || 0;
    filtered.querySelector(".tai-khoan").innerText = data.tai_khoan || 0;
    filtered.querySelector(".date-range").innerText = from + " → " + to;

    renderTopProducts(data.top_products || []);
    renderTopUsers(data.top_users || []);
  }

  function renderTopProducts(products) {
    if (!products || !products.length) return;

    const container = document.querySelector(
      "#filteredDashboard .top-products-container",
    );

    if (!container) return;

    container.innerHTML = "";

    const maxQty = Math.max(...products.map((p) => p.total_quantity || 0));
    const maxRevenue = Math.max(...products.map((p) => p.total_revenue || 0));

    products.forEach((item) => {
      const percentQty = maxQty ? (item.total_quantity / maxQty) * 100 : 0;
      const percentRevenue = maxRevenue
        ? (item.total_revenue / maxRevenue) * 100
        : 0;

      container.innerHTML += `
      <div class="bar-group">
        <div class="bars">
          <div class="bar-units" style="height:${percentQty}%">
            <span class="bar-value text-danger">
              ${Number(item.total_quantity || 0).toLocaleString()}
            </span>
          </div>
          <div class="bar-revenue" style="height:${percentRevenue}%">
            <span class="bar-value text-danger-emphasis">
              ${Number(item.total_revenue || 0).toLocaleString()}đ
            </span>
          </div>
        </div>
        <div class="text-center mt-3">
          <p class="mb-0 fw-bold small text-truncate">
            ${item.ten_san_pham || "N/A"}
          </p>
        </div>
      </div>
    `;
    });
  }

  function renderTopUsers(users) {
    const container = document.querySelector(".user-list");
    if (!container) return;

    container.innerHTML = "";

    users.forEach((user) => {
      const avatar = user.avatar
        ? user.avatar
        : "https://i.imgur.com/6VBx3io.png";

      container.innerHTML += `
      <div class="user-item d-flex justify-content-between align-items-center py-2">
        
        <div class="d-flex align-items-center gap-3">
          <!-- AVATAR -->
          <img src="${avatar}" 
               style="width:40px;height:40px;border-radius:50%;object-fit:cover">
          
          <!-- INFO -->
          <div>
            <div class="fw-bold">${user.ho_ten || "Khách"}</div>
            <small class="text-muted">${user.total_orders || 0} đơn</small>
          </div>
        </div>

        <!-- MONEY -->
        <div class="fw-bold text-danger">
          ${Number(user.total_spent || 0).toLocaleString()}đ
        </div>

      </div>
    `;
    });
  }

  const clearFilterButton = document.getElementById("clearFilter");
  if (clearFilterButton) {
    clearFilterButton.addEventListener("click", function () {
      const filteredSection = document.getElementById("filteredDashboard");
      const mainDashboard = document.getElementById("mainDashboard");
      if (filteredSection) filteredSection.style.display = "none";
      if (mainDashboard) mainDashboard.style.display = "block";
    });
  }

  function closeModal() {
    const modalEl = document.getElementById("dateFilterModal");

    // Ẩn modal thủ công, không dùng bootstrap.Modal.hide()
    modalEl.classList.remove("show");
    modalEl.style.display = "none";
    modalEl.setAttribute("aria-hidden", "true");
    modalEl.removeAttribute("aria-modal");

    // Xóa backdrop
    document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());

    // Reset body
    document.body.classList.remove("modal-open");
    document.body.removeAttribute("style");
  }
  todayBtn.addEventListener("click", function () {
    const today = new Date();

    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, "0");
    const dd = String(today.getDate()).padStart(2, "0");

    const formattedDate = `${yyyy}-${mm}-${dd}`;

    document.getElementById("dateFrom").value = formattedDate;
    document.getElementById("dateTo").value = formattedDate;

    // 🔥 TỰ ĐỘNG CLICK LỌC
    document.getElementById("filterBtn").click();
  });
  loadChart("day");
});
