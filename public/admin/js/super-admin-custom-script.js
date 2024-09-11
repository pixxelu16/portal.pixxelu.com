document.addEventListener('DOMContentLoaded', function() {     
    //Aadhar Number Input Validation
    const aadharNoInput = document.getElementById('aadhar_no');
    aadharNoInput.addEventListener('input', function(event) {
      const inputValue = event.target.value;
      const numericValue = inputValue.replace(/\D/g, ''); 
      const truncatedValue = numericValue.slice(0, 12);
      event.target.value = truncatedValue;
    });
    //Phone Number Input Validation
    const phoneNoInput = document.getElementById('phone_no');
    phoneNoInput.addEventListener('input', function(event) {
       const inputValue = event.target.value;
       const numericValue = inputValue.replace(/\D/g, ''); 
       const truncatedValue = numericValue.slice(0, 10);
       event.target.value = truncatedValue;
    });
    //Pin Code Input Validation
    const pinCodeInput = document.getElementById('pin_code');
    pinCodeInput.addEventListener('input', function(event) {
       const inputValue = event.target.value;
       const numericValue = inputValue.replace(/\D/g, ''); 
       const truncatedValue = numericValue.slice(0, 6);
       event.target.value = truncatedValue;
    });
    //Total Salary Input Validation
    const totalSalaryInput = document.getElementById('total_salary');
    totalSalaryInput.addEventListener('input', function(event) {
       const inputValue = event.target.value;
       const numericValue = inputValue.replace(/\D/g, '');
       event.target.value = numericValue;
    });
});