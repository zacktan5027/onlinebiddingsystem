function checkCategories(form) {
  form.classList.add("was-validated");

  let categoryName = form.categoryName.value.trim();

  let emptyField = "";
  let filled = true;

  if (categoryName === "") {
    form.categoryName.value = "";
    filled = false;
  }

  if (filled === false) {
    return filled;
  } else {
    return filled;
  }
}
