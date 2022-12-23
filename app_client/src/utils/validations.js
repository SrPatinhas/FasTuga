const required = (propertyType) => {
	return v => v && v.length > 0 || `You must input a ${propertyType}`
}
const minLength = (propertyType, minLength) => {
	return v => v && v.length >= minLength || `${propertyType} must be at least ${minLength} characters`
}
const maxLength = (propertyType, maxLength) => {
	return v => v && v.length <= maxLength || `${propertyType} must be less than ${maxLength} characters`
}

const emailFormat = () => {
	let regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,24})+$/
    return v => v && regex.test(v) || "Must be a valid email"
}

const regex = {
	email: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+(pt|com)))$/,
	phone: new RegExp('^(9)[0-9]{8,}$'),
	visa: /^4[0-9]{12}(?:[0-9]{3})?$/g,
	visaMaster: /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/g,
	nif: new RegExp('^[0-9]{8,9}$')
}

const validateEmail = (email) => {
  return String(email).toLowerCase().match(regex.email);
};
const validatePhoneNumber = (phone) => {
  return phone.match(regex.phone);
}
const validateVisaCard = (card) => {
  // Visa Card
  const isVisa = card.match(regex.visa);
  // Visa Master Card:
  const isVisaMaster = card.match(regex.visaMaster);
  return isVisa || isVisaMaster;
}
const validateNIF = (nif) => {
	return nif.match(regex.nif);
}

const isValidEmail = (email) => {
	let mail = String(email).toLowerCase();
	return regex.email.test(mail);
};
const isValidPhoneNumber = (phone) => {
	phone = parseInt(phone)
	return regex.phone.test(phone);
}
const isValidNIF = (nif) => {
	return regex.nif.test(nif);
}

export default {
    required,
    minLength,
    maxLength,
    emailFormat,
    validateEmail,
    validatePhoneNumber,
    validateVisaCard,
	validateNIF,

	isValidEmail,
	isValidPhoneNumber,
	isValidNIF
}
  