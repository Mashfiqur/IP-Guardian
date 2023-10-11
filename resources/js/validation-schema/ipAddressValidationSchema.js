import * as Yup from 'yup';

// action: 1 => create, 2 => Update
export const IpAddressSchema = (action) => {
    const commonFields = {
        label: Yup.string().required('Label is required'),
        comment: Yup.string().nullable(),
    };

    if (action === 1) {
        return Yup.object().shape({
            ip: Yup.string()
                .required('IP is required')
                .test('ipAddress', 'Invalid IP address', (value) =>
                    /^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/.test(value)
                ),
            ...commonFields,
        });
    } else if (action === 2) {
        return Yup.object().shape(commonFields);
    }
};
