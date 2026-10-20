(() => {
  const form = document.querySelector("#contact-form");
  if (!form) return;

  form.addEventListener("submit", () => {
    const firstNameField = form.elements.namedItem("nome");
    const lastNameField = form.elements.namedItem("ultimo_nome");
    const firstName = firstNameField.value.trim();
    const lastName = lastNameField.value.trim();

    firstNameField.value = [firstName, lastName].filter(Boolean).join(" ");
  });
})();
