/**
 * @jest-environment jsdom
 */

const $ = require('jquery');
global.$ = $;

const saveUser = (actionUrl, formData) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function (response) {
                const data = JSON.parse(response);
                if (data.success) {
                    resolve(data);
                } else {
                    reject(data.error || 'An unexpected error occurred.');
                }
            },
            error: function (xhr) {
                reject(xhr.responseText || 'AJAX request failed.');
            }
        });
    });
};

test('saveUser with success', async () => {
    $.ajax = jest.fn().mockImplementation(({ success }) => {
        success(JSON.stringify({ success: true, message: 'User created successfully.' }));
    });

    const response = await saveUser('/create', { name: 'John Doe', email: 'john.doe@example.com' });

    expect(response).toEqual({ success: true, message: 'User created successfully.' });
});

test('saveUser with error ', async () => {
    $.ajax = jest.fn().mockImplementation(({ error }) => {
        error({ responseText: 'Error saving user.' });
    });

    await expect(saveUser('/create', { name: 'John Doe', email: 'invalid-email' })).rejects.toEqual('Error saving user.');
});