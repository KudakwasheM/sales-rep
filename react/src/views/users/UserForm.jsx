import React, { useState } from "react";
import { useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../../../../../holicAPI/react/src/axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const UserForm = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const { setNotifiation } = useStateContext();
    const [user, setUser] = useState({
        id: null,
        name: "",
        email: "",
        username: "",
        ec_number: "",
        phone: "",
        role_id: null,
        password: "",
        password_confirmation: "",
    });

    const onSubmit = (e) => {
        e.preventDefault();
        if (user.id) {
            console.log(user);
            axiosClient
                .put(`/users/${user.id}`, user)
                .then((response) => {
                    setNotification("User successfully updated");
                    navigate("/users");
                })
                .catch((err) => {
                    const response = err.response;
                    if (response && response.status == 422) {
                        setErrors(response.data.errors);
                    }
                });
        } else {
            axiosClient
                .post("/users", user)
                .then(() => {
                    setNotification("User successfully created");
                    navigate("/users");
                })
                .catch((err) => {
                    const response = err.response;
                    if (response && response.status == 422) {
                        setErrors(response.data.errors);
                    }
                });
        }
    };

    const getUser = () => {
        setLoading(true);

        axiosClient.get(`/users/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setUser(data);
        });
    };

    if (id) {
        useEffect(() => {
            getUser();
        }, []);
    }

    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                {user.id && (
                    <h2 className="text-xl font-lg text-center mb-4">
                        Update User: {user.name}
                    </h2>
                )}
                {!user.id && (
                    <h2 className="text-xl font-lg text-center mb-4">
                        Create New User
                    </h2>
                )}

                <div>
                    {loading && <div className="text-center">Loading...</div>}
                    {errors && (
                        <div className="alert">
                            {Object.keys(errors).map((key) => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    )}
                    {!loading && (
                        <form onSubmit={onSubmit} className="flex flex-col">
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
                                value={user.name}
                                onChange={(e) =>
                                    setUser({ ...user, name: e.target.value })
                                }
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
                                    {!user.id && "CREATE"}
                                    {user.id && "UPDATE"}
                                </button>
                                <button className="py-3 bg-red-400 text-white w-1/2">
                                    CANCEL
                                </button>
                            </div>
                        </form>
                    )}
                </div>
            </div>
        </>
    );
};

export default UserForm;
