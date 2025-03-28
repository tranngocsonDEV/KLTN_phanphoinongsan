const Validator = (function () {
  const errors = {}; // Lưu trữ các lỗi của từng trường

  // Hiển thị lỗi bằng tooltip
  function showTooltipError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    // Nếu tooltip đã tồn tại, dispose trước
    const existingTooltip = bootstrap.Tooltip.getInstance(field);
    if (existingTooltip) existingTooltip.dispose();

    // Đánh dấu trường không hợp lệ
    field.classList.add("is-invalid");

    // Thiết lập tooltip
    field.setAttribute("data-bs-toggle", "tooltip");
    field.setAttribute("data-bs-placement", "top");
    field.setAttribute("title", message);

    // Kích hoạt tooltip
    const tooltip = new bootstrap.Tooltip(field);
    tooltip.show();

    // Thêm lỗi vào danh sách
    errors[fieldId] = message;
  }

  // Xóa tooltip lỗi
  function clearTooltipError(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    // Xóa đánh dấu không hợp lệ
    field.classList.remove("is-invalid");

    // Xóa tooltip
    const tooltip = bootstrap.Tooltip.getInstance(field);
    if (tooltip) tooltip.dispose();

    // Xóa lỗi khỏi danh sách
    delete errors[fieldId];
  }

  // Kiểm tra trạng thái hợp lệ của toàn bộ form
  function isValid() {
    return Object.keys(errors).length === 0;
  }

  return {
    showError: showTooltipError,
    clearError: clearTooltipError,
    isValid
  };
})();
