import React from "react";

const UserForm = () => {
    return (
        <div>
            <div className="bg-white p-5 shadow-md flex flex-col">
                <h2 className="text-xl font-lg text-center mb-4">
                    Create New User
                </h2>
                <div>
                    <form className="flex flex-col">
                        {/* {errors && (
                        <div className="bg-red-500 text-white p-2 my-2">
                            {Object.keys(errors).map((key) => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    )} */}
                        <label htmlFor="">Full Name</label>
                        <input
                            className="py-2 px-2 mb-3 border border-gray-200"
                            type="text"
                            placeholder="Kudakwashe Masaya"
                        />
                        <label htmlFor="">Email</label>
                        <input
                            className="py-2 px-2 mb-3 border border-gray-200"
                            type="email"
                            placeholder="masyakudakwashe@gmail.com"
                        />
                        <label htmlFor="">EC Number</label>
                        <input
                            className="py-2 px-2 mb-3 border border-gray-200"
                            type="email"
                            placeholder="KUD007"
                        />
                        <label htmlFor="">Username</label>
                        <input
                            className="py-2 px-2 mb-3 border border-gray-200"
                            type="text"
                            placeholder="creator123"
                        />
                        <label htmlFor="">Phone</label>
                        <input
                            className="py-2 px-2 mb-3 border border-gray-200"
                            type="text"
                            placeholder="+263719123456"
                        />
                        <label htmlFor="">Role</label>
                        <select className="py-2 px-2 mb-3 border border-gray-200">
                            <option value="" disabled>
                                --- Select Role ---
                            </option>
                            <option value="2">Admin</option>
                            <option value="3">Administration</option>
                            <option value="4">SalesRep</option>
                        </select>
                        <label htmlFor="">Passwword</label>
                        <input
                            className="py-2 px-2 mb-3 border border-gray-200"
                            type="password"
                            placeholder="**********"
                        />
                        <label htmlFor="">Confirm Password</label>
                        <input
                            className="py-2 px-2 mb-3 border border-gray-200"
                            type="password"
                            placeholder="**********"
                        />
                        <div className="flex justify-between">
                            <button className="py-3 bg-green-400 text-white w-1/2">
                                CREATE
                            </button>
                            <button className="py-3 bg-red-400 text-white w-1/2">
                                CANCEL
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default UserForm;
