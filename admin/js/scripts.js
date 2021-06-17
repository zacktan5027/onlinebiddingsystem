window.addEventListener("DOMContentLoaded", (event) => {
  // Toggle the side navigation
  const sidebarToggle = document.body.querySelector("#sidebarToggle");
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", (event) => {
      event.preventDefault();
      document.body.classList.toggle("sb-sidenav-toggled");
      localStorage.setItem(
        "sb|sidebar-toggle",
        document.body.classList.contains("sb-sidenav-toggled")
      );
    });
  }
});

window.addEventListener("DOMContentLoaded", (event) => {
  const staffList = document.getElementById("staffList");
  if (staffList) {
    new simpleDatatables.DataTable(staffList);
  }

  const manageStaffTable = document.getElementById("manageStaffTable");
  if (manageStaffTable) {
    new simpleDatatables.DataTable(manageStaffTable);
  }

  const manageCategoryTable = document.getElementById("manageCategoryTable");
  if (manageCategoryTable) {
    new simpleDatatables.DataTable(manageCategoryTable);
  }

  const totalSuccessCategoryTable = document.getElementById(
    "totalSuccessCategoryTable"
  );
  if (totalSuccessCategoryTable) {
    new simpleDatatables.DataTable(totalSuccessCategoryTable);
  }

  const totalSuccessDateTable = document.getElementById(
    "totalSuccessDateTable"
  );
  if (totalSuccessDateTable) {
    new simpleDatatables.DataTable(totalSuccessDateTable);
  }

  const totalBiddingCategoryTable = document.getElementById(
    "totalBiddingCategoryTable"
  );
  if (totalBiddingCategoryTable) {
    new simpleDatatables.DataTable(totalBiddingCategoryTable);
  }

  const totalBiddingDateTable = document.getElementById(
    "totalBiddingDateTable"
  );
  if (totalBiddingDateTable) {
    new simpleDatatables.DataTable(totalBiddingDateTable);
  }

  const totalFavouriteCategoryTable = document.getElementById(
    "totalFavouriteCategoryTable"
  );
  if (totalFavouriteCategoryTable) {
    new simpleDatatables.DataTable(totalFavouriteCategoryTable);
  }

  const totalItemTable = document.getElementById("totalItemTable");
  if (totalItemTable) {
    new simpleDatatables.DataTable(totalItemTable);
  }
});
