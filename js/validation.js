function validate(form) {
    fail = validateName(form.name.value)
    fail += validateOtzyv(form.otzyv.value)
    if (fail == "") {
        return true
    }
    else {
        alert(fail);
        return false
    }
}

function validateName(field) {
    return (field == "") ? "Пожалуйста, введите свое имя. \n" : ""
}

function validateOtzyv(field) {
    return (field == "") ? "Пожалуйста, введите отзыв. \n" : ""
}
