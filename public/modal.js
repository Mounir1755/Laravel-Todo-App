function showCategoryForm() {
    const modal = document.getElementById("categoryFormModal");

    if (modal.classList.contains("hidden")) {
        modal.classList.remove("hidden");
    } else {
        modal.classList.add("hidden");
    }
}

function showTaskForm() {
    const modal = document.getElementById("taskFormModal");

    if (modal.classList.contains("hidden")) {
        modal.classList.remove("hidden");
    } else {
        modal.classList.add("hidden");
    }
}
