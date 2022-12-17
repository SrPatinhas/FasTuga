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

const validateEmail = (email) => {
  return String(email).toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
};

const validatePhoneNumber = (phone) => {
  return phone.match(/^(9)[/0-9]{8}$/g);
}

const validateVisaCard = (card) => {
  // Visa Card
  const isVisa = card.match(/^4[0-9]{12}(?:[0-9]{3})?$/g);
  // Visa Master Card:
  const isVisaMaster = card.match(/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/g);
  return isVisa || isVisaMaster;
}

export default {
    required,
    minLength,
    maxLength,
    emailFormat,
    validateEmail,
    validatePhoneNumber,
    validateVisaCard
}
  