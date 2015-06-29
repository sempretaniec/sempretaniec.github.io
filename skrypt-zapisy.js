function check_form(f) {
    if (f.imie.value == '' ||
        f.email.value == '' ||
        f.numer.value == '') {
        alert('Pole wymagane jest puste! wypełnij go!');
        return false;
    } 
  
    maska = /^[0-9a-z_.-]+@([0-9a-z-]+.)+[a-z]{2,4}$/i;
  if (maska.test(f.email.value)==false) {
    alert("Wpisz poprawny adres e-mail!");
    return false;
    } 

  return true; 
} 
//--> 
