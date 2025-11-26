using System.Text;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

using forecast_management_system.Views.Dashboard;

namespace forecast_management_system
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();

            MainContent.Content = new Dashboard();
        }

        private void OpenDashboard(object sender, RoutedEventArgs e)
        {
            MainContent.Content = new Dashboard();
        }
        private void OpenInputSelling(object sender, RoutedEventArgs e)
        {
            MainContent.Content = new InputSelling();
        }
        private void OpenTransactionList(object sender, RoutedEventArgs e)
        {
            MainContent.Content = new TransactionList();
        }
        private void OpenManageReview(object sender, RoutedEventArgs e)
        {
            MainContent.Content = new ManageReview();
        }
        private void OpenSalesReport(object sender, RoutedEventArgs e)
        {
            MainContent.Content = new SalesReport();
        }
    }
}