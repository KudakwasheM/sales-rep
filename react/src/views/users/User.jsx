import React, { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";

const User = () => {
    const { id } = useParams();
    const [loading, setLoading] = useState(false);
    const [user, setUser] = useState({});
    const [plan, setPlan] = useState({});

    const getUser = () => {
        setLoading(true);
        axiosClient.get(`/users/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setUser(data);
        });
    };

    const getUserPlan = () => {
        setLoading(true);
        axiosClient.get(`clients/${client.id}/plan`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setPlan(data);
        });
    };

    if (id) {
        useEffect(() => {
            getUser();
            getUserPlan();
        }, []);
    }

    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                <h2 className="text-xl font-lg text-center mb-4">
                    Showing User: {user.name}
                </h2>
                <div>
                    {loading && (
                        <div className="my-2 text-center">Loading...</div>
                    )}
                    {!loading && (
                        <div className="flex flex-row w-full justify-around">
                            <div className="user-details border border-1 w-5/12">
                                <table className="table-fixed">
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Name
                                        </th>
                                        <td className="w-1/2">{user.name}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Email
                                        </th>
                                        <td className="w-1/2">{user.email}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Username
                                        </th>
                                        <td className="w-1/2">
                                            {user.username}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            EC Number
                                        </th>
                                        <td className="w-1/2">
                                            {user.ec_number}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Phone
                                        </th>
                                        <td className="w-1/2">{user.phone}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Role
                                        </th>
                                        <td className="w-1/2">
                                            {user.role_id}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div className="plan-details border border-1 w-5/12">
                                {!plan && (
                                    <div className="flex items-center justify-center">
                                        <Link
                                            to=""
                                            className="bg-green-500 py-3 px-2"
                                        >
                                            Add Plan
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
};

export default User;
