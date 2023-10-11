import * as Yup from 'yup';

export const loginRequestSchema = Yup.object().shape({
    email: Yup.string()
        .required('Email is required')
        .email('Email is invalid'),
    password: Yup.string()
        .min(4, 'Password must be at least 4 characters')
        .required('Password is required'),
});

export const profileUpdateSchema = Yup.object().shape({
    name: Yup.string()
        .required('Name is required'),
    email: Yup.string()
        .required('Email is required')
        .email('Email is invalid'),
    password: Yup.string().nullable(),
    password_confirmation: Yup.string()
        .when('password', (password) => {
            if (password && password[0] !== undefined) {
                return Yup.string()
                    .required('Password Confirmation is required')
                    .oneOf([Yup.ref('password')], 'Password does not match.')
            }
        }),
});