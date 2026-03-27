document.addEventListener("DOMContentLoaded", function () {
  const labelsContainer = document.querySelector(".chart-labels");
  const buttons = document.querySelectorAll(".chart-filter button");
  const svg = document.querySelector(".chart-container svg");

  // ===== TOOLTIP =====
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

  // ===== FORMAT DATE (FIX TIMEZONE) =====
  function formatDateLocal(date) {
    let y = date.getFullYear();
    let m = String(date.getMonth() + 1).padStart(2, "0");
    let d = String(date.getDate()).padStart(2, "0");

    return `${y}-${m}-${d}`;
  }

  // ===== LABEL =====
  function renderLabels(type) {
    let labels = [];

    if (type === "day") {
      for (let i = 6; i >= 0; i--) {
        let d = new Date();
        d.setDate(d.getDate() - i);
        labels.push(d.getDate());
      }
    }

    if (type === "week") {
      labels = ["T2", "T3", "T4", "T5", "T6", "T7", "CN"];
    }

    if (type === "month") {
      labels = [
        "Th1",
        "Th2",
        "Th3",
        "Th4",
        "Th5",
        "Th6",
        "Th7",
        "Th8",
        "Th9",
        "Th10",
        "Th11",
        "Th12",
      ];
    }

    labelsContainer.innerHTML = labels.map((l) => `<span>${l}</span>`).join("");
  }

  // ===== 7 NGÀY GẦN NHẤT =====
  function fill7Days(data) {
    let result = [];
    let today = new Date();

    for (let i = 6; i >= 0; i--) {
      let d = new Date();
      d.setDate(today.getDate() - i);

      let dateStr = formatDateLocal(d);

      let found = data.find((x) => x.ngay === dateStr);

      result.push({
        value: found ? Number(found.doanh_thu) : 0,
      });
    }

    return result;
  }

  // ===== TUẦN (T2 → CN) =====
  function getWeekData(data) {
    let result = [];

    let today = new Date();
    let day = today.getDay();

    if (day === 0) day = 7;

    let monday = new Date(today);
    monday.setDate(today.getDate() - day + 1);

    for (let i = 0; i < 7; i++) {
      let d = new Date(monday);
      d.setDate(monday.getDate() + i);

      let dateStr = formatDateLocal(d);

      let found = data.find((x) => x.ngay === dateStr);

      result.push({
        value: found ? Number(found.doanh_thu) : 0,
      });
    }

    return result;
  }

  // ===== CONVERT DATA =====
  function convertData(type) {
    let arr = [];

    if (type === "day") {
      arr = fill7Days(data7Ngay);
    }

    if (type === "week") {
      arr = getWeekData(data7Ngay);
    }

    if (type === "month") {
      let temp = new Array(12).fill(0);

      data12Thang.forEach((item) => {
        temp[item.thang - 1] = Number(item.doanh_thu);
      });

      arr = temp.map((v) => ({ value: v }));
    }

    return arr;
  }

  // ===== DRAW CHART =====
  function drawChart(data) {
    if (!data || data.length === 0) return;

    let max = Math.max(...data.map((i) => i.value), 1);
    let step = 100 / (data.length - 1);

    let path = "";

    data.forEach((point, index) => {
      let x = index * step;
      let y = 40 - (point.value / max) * 30;

      path += index === 0 ? `M${x},${y}` : ` L${x},${y}`;
    });

    document.querySelector(".line-chart").setAttribute("d", path);
    document
      .querySelector(".area-chart")
      .setAttribute("d", path + " L100,40 L0,40 Z");

    // remove dot cũ
    document.querySelectorAll(".dot").forEach((e) => e.remove());

    // vẽ dot
    data.forEach((point, index) => {
      let x = index * step;
      let y = 40 - (point.value / max) * 30;

      let circle = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "circle",
      );

      circle.setAttribute("cx", x);
      circle.setAttribute("cy", y);
      circle.setAttribute("r", 1.5);
      circle.setAttribute("fill", "#b70011");
      circle.classList.add("dot");

      // hover
      circle.addEventListener("mousemove", (e) => {
        tooltip.style.display = "block";
        tooltip.style.left = e.pageX + 10 + "px";
        tooltip.style.top = e.pageY - 20 + "px";

        let label = labelsContainer.children[index]?.innerText || "";

        tooltip.innerHTML = `
          ${label} <br>
          ${point.value.toLocaleString()} đ
        `;
      });

      circle.addEventListener("mouseenter", () => {
        circle.setAttribute("r", 2.5);
      });

      circle.addEventListener("mouseleave", () => {
        tooltip.style.display = "none";
        circle.setAttribute("r", 1.5);
      });

      svg.appendChild(circle);
    });
  }

  // ===== LOAD =====
  function loadChart(type) {
    renderLabels(type);
    let data = convertData(type);
    drawChart(data);
  }

  // ===== CLICK =====
  buttons.forEach((btn) => {
    btn.addEventListener("click", function () {
      buttons.forEach((b) => b.classList.remove("active", "bg-red-light"));
      this.classList.add("active", "bg-red-light");

      loadChart(this.dataset.type);
    });
  });

  // init
  loadChart("day");
});
