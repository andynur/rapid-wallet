import BlocksLayout from '@/Layouts/BlocksLayout';
import { Badge } from '@/shadcn/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/shadcn/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/shadcn/ui/table';
import type { PageProps, Transactions } from '@/types';
import { HandCoins } from 'lucide-react';

export default function Dashboard({ auth, totalBalance, transactions }: PageProps<{ totalBalance: number, transactions: Array<Transactions> }>) {
    return (
        <BlocksLayout user={auth.user}>
            <div className="grid gap-4 md:grid-cols-2 md:gap-8 lg:grid-cols-4">
                <Card x-chunk="dashboard-01-chunk-0">
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">
                            Wallet Balance
                        </CardTitle>
                        <HandCoins className="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">Rp {Intl.NumberFormat("id").format(totalBalance)}</div>
                    </CardContent>
                </Card>
            </div>
            <div className="grid">
                <Card x-chunk="dashboard-01-chunk-4"
                >
                    <CardHeader className="flex flex-row items-center">
                        <div className="grid gap-2">
                            <CardTitle>Transactions</CardTitle>
                            <CardDescription>
                                Recent transactions from your account.
                            </CardDescription>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>
                                        Order ID
                                    </TableHead>
                                    <TableHead>
                                        Date
                                    </TableHead>
                                    <TableHead>
                                        Amount
                                    </TableHead>
                                    <TableHead>
                                        Type
                                    </TableHead>
                                    <TableHead>
                                        Status
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {/* TODO: use tanstack datatable for better ux */}
                                {
                                    transactions.map(trx =>
                                        <TableRow key={trx.id}>
                                            <TableCell>
                                                {trx.order_id}
                                            </TableCell>
                                            <TableCell>
                                                {trx.timestamp}
                                            </TableCell>
                                            <TableCell className="text-right font-semibold">
                                                Rp {Intl.NumberFormat("id").format(trx.amount)}
                                            </TableCell>
                                            <TableCell>
                                                <Badge className="text-xs" variant="outline">
                                                    {trx.type}
                                                </Badge>
                                            </TableCell>
                                            <TableCell>
                                                <Badge className="text-xs" variant="secondary">
                                                    {trx.status}
                                                </Badge>
                                            </TableCell>
                                        </TableRow>
                                    )
                                }
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </BlocksLayout>
    );
}
