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
    const { setNotification } = useStateContext();
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

    const onSubmit = async (e) => {
        e.preventDefault();
        if (user.id) {
            await axiosClient
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
            console.log(user);
            await axiosClient
                .post("/users", user)
                .then((response) => {
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

    const getUser = async () => {
        setLoading(true);

        await axiosClient.get(`/users/${id}`).then(({ data }) => {
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
                        <div className="bg-red-500 text-white p-2">
                            {Object.keys(errors).map((key) => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    )}
                    {!loading && (
                        <form onSubmit={onSubmit} className="flex flex-col">
                            <label htmlFor="">Full Name</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={user.name}
                                onChange={(e) =>
                                    setUser({ ...user, name: e.target.value })
                                }
                                placeholder="Kudakwashe Masaya"
                            />
                            <label htmlFor="">EC Number</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                type="text"
                                value={user.ec_number}
                                onChange={(e) =>
                                    setUser({
                                        ...user,
                                        ec_number: e.target.value,
                                    })
                                }
                                placeholder="KUD007"
                            />
                            <label htmlFor="">Email</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                type="email"
                                value={user.email}
                                onChange={(e) =>
                                    setUser({ ...user, email: e.target.value })
                                }
                                placeholder="masyakudakwashe@gmail.com"
                            />
                            <label htmlFor="">Username</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                type="text"
                                value={user.username}
                                onChange={(e) =>
                                    setUser({
                                        ...user,
                                        username: e.target.value,
                                    })
                                }
                                placeholder="creator123"
                            />
                            <label htmlFor="">Phone</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                type="text"
                                value={user.phone}
                                onChange={(e) =>
                                    setUser({ ...user, phone: e.target.value })
                                }
                                placeholder="+263719123456"
                            />
                            <label htmlFor="">Role</label>
                            <select
                                className="py-2 px-2 mb-3 border border-gray-200"
                                value={user.role_id}
                                onChange={(e) =>
                                    setUser({
                                        ...user,
                                        role_id: e.target.value,
                                    })
                                }
                                name="role_id"
                            >
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
                                value={user.password}
                                onChange={(e) =>
                                    setUser({
                                        ...user,
                                        password: e.target.value,
                                    })
                                }
                                placeholder="**********"
                            />
                            <label htmlFor="">Confirm Password</label>
                            <input
                                className="py-2 px-2 mb-3 border border-gray-200"
                                type="password"
                                onChange={(e) =>
                                    setUser({
                                        ...user,
                                        password_confirmation: e.target.value,
                                    })
                                }
                                placeholder="**********"
                            />
                            <button className="py-3 bg-green-400 text-white">
                                {!user.id && "CREATE"}
                                {user.id && "UPDATE"}
                            </button>
                        </form>
                    )}
                </div>
            </div>
        </>
    );
};

export default UserForm;
