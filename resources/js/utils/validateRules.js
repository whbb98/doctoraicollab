export const validateEmail = [
    v => !!v || 'Email is required !',
    v => /.+@.+\..+/.test(v) || 'Enter a valid email address',
]

export const validateDigits = [
    v => !!v || 'Digits required !',
    v => /^\d+$/.test(v) || 'Enter a valid phone number'
]
