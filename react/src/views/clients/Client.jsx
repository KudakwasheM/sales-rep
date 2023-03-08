import React, { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";

const Client = () => {
    const { id } = useParams();
    const [loading, setLoading] = useState(false);
    const [client, setClient] = useState({});
    const [plan, setPlan] = useState([]);

    const getClient = () => {
        setLoading(true);
        axiosClient.get(`/clients/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setClient(data);
        });
    };

    const getClientPlan = () => {
        setLoading(true);
        axiosClient.get(`clients/${id}/plan`).then(({ data }) => {
            console.log(data);
            // setLoading(false);
            // setPlan(data);
        });
    };

    if (id) {
        useEffect(() => {
            getClient();
            getClientPlan();
        }, []);
    }
    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                <h2 className="text-xl font-lg text-center mb-4">
                    Showing client: {client.name}
                </h2>
                <div>
                    {loading && (
                        <div className="my-2 text-center">Loading...</div>
                    )}
                    {!loading && (
                        <div className="flex flex-row w-full justify-around">
                            <div className="client-details border border-1 w-5/12">
                                <table className="table-fixed">
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Name
                                        </th>
                                        <td className="w-1/2">{client.name}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            ID Number
                                        </th>
                                        <td className="w-1/2 right-0">
                                            {client.id_number}
                                        </td>
                                    </tr>
                                    {client.ec_number && (
                                        <tr>
                                            <th className="text-start w-1/2 py-3">
                                                EC Number
                                            </th>
                                            <td className="w-1/2">
                                                {client.clientname}
                                            </td>
                                        </tr>
                                    )}
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            D.O.B
                                        </th>
                                        <td className="w-1/2">{client.dob}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Type
                                        </th>
                                        <td className="w-1/2">{client.type}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Battery Number
                                        </th>
                                        <td className="w-1/2">
                                            {client.battery_number}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th className="text-start w-1/2 py-3">
                                            Created By
                                        </th>
                                        <td className="w-1/2">
                                            {client.created_by}
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
                                {plan && (
                                    <div className="border border-1 w-5/12">
                                        <table className="table-fixed">
                                            <tr>
                                                <th className="text-start w-1/2 py-3">
                                                    Battery Type
                                                </th>
                                                <td className="w-1/2">
                                                    {plan.battery_type}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th className="text-start w-1/2 py-3">
                                                    Amount
                                                </th>
                                                <td className="w-1/2">
                                                    {plan.amount}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th className="text-start w-1/2 py-3">
                                                    Deposit
                                                </th>
                                                <td className="w-1/2">
                                                    {plan.deposit}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th className="text-start w-1/2 py-3">
                                                    Installments
                                                </th>
                                                <td className="w-1/2">
                                                    {plan.installments}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th className="text-start w-1/2 py-3">
                                                    Paid Installments
                                                </th>
                                                <td className="w-1/2">
                                                    {plan.paid_installments}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th className="text-start w-1/2 py-3">
                                                    Balance
                                                </th>
                                                <td className="w-1/2">
                                                    {plan.balance}
                                                </td>
                                            </tr>
                                        </table>
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

export default Client;
