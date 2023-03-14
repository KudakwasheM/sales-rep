import React, { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";

const Plan = () => {
    const { id } = useParams();
    const [loading, setLoading] = useState(false);
    const [plan, setPlan] = useState({});

    const onDelete = async (plan) => {
        if (!window.confirm("Are you sure you want to delete this plan?")) {
            return;
        }

        await axiosClient.delete(`/plans/${plan.id}`).then(() => {
            setNotification("Plan deleted successfuly.");
            getAllplans();
        });
    };

    const getPlan = () => {
        setLoading(true);
        axiosClient.get(`/plans/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setPlan(data);
        });
    };

    if (id) {
        useEffect(() => {
            getPlan();
        }, []);
    }

    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                <h2 className="text-xl font-lg text-center mb-4">
                    Showing Details For Plan {plan.id}
                </h2>
                <div>
                    {loading && (
                        <div className="my-2 text-center">Loading...</div>
                    )}
                    {!loading && (
                        <div className="flexx flex-col w-full justify-around items-center">
                            <div className="border border-1 mb-2">
                                <table className="table-fixed w-full">
                                    <tr className="">
                                        <th className="text-start py-3 pl-1">
                                            Amount
                                        </th>
                                        <td>{plan.amount}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Battery Type
                                        </th>
                                        <td>{plan.battery_type}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Installments
                                        </th>
                                        <td>{plan.installments}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Paid Installments
                                        </th>
                                        <td>{plan.paid_installments}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Deposit
                                        </th>
                                        <td>{plan.deposit}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Balance
                                        </th>
                                        <td>{plan.balance}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Client
                                        </th>
                                        <td>{plan.client_id}</td>
                                    </tr>
                                </table>
                            </div>
                            <div className="flex flex-row">
                                <Link
                                    to={"/plans/" + plan.id}
                                    className="w-1/2 bg-green-500 text-white py-3 pl-1 text-center"
                                >
                                    EDIT
                                </Link>
                                <button
                                    onClick={(ev) => onDelete(plan)}
                                    className="w-1/2 bg-red-500 text-white py-3 pl-1"
                                >
                                    DELETE
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
};

export default Plan;
